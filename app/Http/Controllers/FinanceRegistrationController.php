<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Student;
use App\Models\Formation;
use App\Models\Center;
use App\Models\PaymentMethod;
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class FinanceRegistrationController extends Controller
{
    /**
     * Affiche la liste des élèves en attente de validation financière
     */
    public function pendingStudents(Request $request)
    {
        $query = User::where('account_type', 'student')
            ->whereHas('student', function ($q) {
                $q->where('fully_registered', false);
            })
            ->with(['student', 'roles']);

        // Filtres de recherche
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone_number', 'like', "%{$search}%")
                  ->orWhereHas('student', function($sq) use ($search) {
                      $sq->where('establishment', 'like', "%{$search}%");
                  });
            });
        }

        // Filtre par ville
        if ($request->filled('city')) {
            $query->where('city', $request->city);
        }

        // Filtre par établissement
        if ($request->filled('establishment')) {
            $query->whereHas('student', function($q) use ($request) {
                $q->where('establishment', 'like', "%{$request->establishment}%");
            });
        }

        // Tri
        $sortField = $request->get('sort', 'created_at');
        $sortDirection = $request->get('direction', 'desc');

        $validSortFields = ['created_at', 'first_name', 'last_name', 'email'];
        if (in_array($sortField, $validSortFields)) {
            $query->orderBy($sortField, $sortDirection);
        } else {
            $query->latest();
        }

        $pendingStudents = User::where('account_type', 'student')
            ->whereHas('student', fn ($q) => $q->where('fully_registered', false))
            ->with(['student.registration', 'roles'])
            ->paginate(15);

        // Données pour les filtres
        $cities = User::where('account_type', 'student')
            ->whereNotNull('city')
            ->distinct()
            ->pluck('city')
            ->sort();

        $centers = Center::where('is_active', true)
            ->orderBy('name')
            ->get();

        $establishments = Student::whereNotNull('establishment')
            ->distinct()
            ->pluck('establishment')
            ->sort();

        // Statistiques
        $stats = [
            'total_pending' => User::where('account_type', 'student')
                ->where('status', User::STATUS_PENDING_VALIDATION)
                ->count(),
            'pending_contract' => User::where('account_type', 'student')
                ->where('status', User::STATUS_PENDING_CONTRACT)
                ->count(),
            'validated_today' => User::where('account_type', 'student')
                ->where('status', User::STATUS_ACTIVE)
                ->whereDate('validated_at', today())
                ->count(),
            'rejected_total' => User::where('account_type', 'student')
                ->where('status', User::STATUS_REJECTED)
                ->count(),
        ];

        return view('admin.finance.students.pending', compact(
            'pendingStudents',
            'cities',
            'centers',
            'establishments',
            'stats'
        ));
    }

    /**
     * Affiche les détails d'un élève en attente
     */
    public function showStudent($locale, User $student)
    {
        // Vérifier que c'est bien un élève en attente
        if ($student->account_type !== 'student' || $student->status !== User::STATUS_PENDING_VALIDATION) {
            abort(404, 'Élève non trouvé ou déjà traité');
        }

        $student->load(['student']);

        return view('admin.finance.students.show', compact('student'));
    }

    /**
     * Affiche le formulaire de finalisation d'inscription
     */
    public function finalizeRegistration($locale, User $student)
    {
        // Vérifier que c'est bien un élève en attente
        if ($student->account_type !== 'student' || $student->status !== User::STATUS_PENDING_VALIDATION) {
            abort(404, 'Élève non trouvé ou déjà traité');
        }

        $student->load(['student']);

        // Données nécessaires pour le formulaire
        $formations = Formation::with('phase')->orderBy('name')->get();
        $centers = Center::where('is_active', true)
            ->orderBy('name')
            ->select('id', 'name', 'city') // Charger uniquement les champs nécessaires
            ->get();
        $paymentMethods = PaymentMethod::orderBy('label')->get();

        return view('admin.finance.students.finalize', compact(
            'student',
            'formations',
            'centers',
            'paymentMethods'
        ));
    }

    /**
     * Traite la finalisation d'inscription avec mise à jour des infos élève
     */
    public function processRegistration(Request $request, $locale, User $student)
    {
        // Vérifier que c'est bien un élève en attente
        if ($student->account_type !== 'student' || $student->status !== User::STATUS_PENDING_VALIDATION) {
            abort(404, 'Élève non trouvé ou déjà traité');
        }

        $validated = $request->validate([
            // Validation des informations personnelles de l'élève
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users')->ignore($student->id)
            ],
            'phone_number' => [
                'required',
                'string',
                'max:20',
                Rule::unique('users')->ignore($student->id)
            ],
            'parent_phone_number' => 'nullable|string|max:20',
            'establishment' => 'required|string|max:255',
            'center_id' => 'required|exists:centers,id',

            // Validation des informations d'inscription
            'formations' => 'required|array|min:1',
            'formations.*' => 'exists:formations,id',
            'payment_method_id' => 'required|exists:payment_methods,id',
            'receipt_number' => 'required|string|unique:registrations,receipt_number',
            'amount_received' => 'required|numeric|min:0',
            'contract_amount' => 'required|numeric|min:0',
            'special_conditions' => 'nullable|string|max:1000',
        ]);

        DB::beginTransaction();

        try {
            // Récupérer le centre sélectionné pour obtenir sa ville
            $selectedCenter = Center::find($validated['center_id']);
            if (!$selectedCenter) {
                throw new \Exception('Le centre sélectionné est invalide.');
            }

            // Mettre à jour les informations de l'utilisateur

            $user = User::with('student')->where('email', $validated['email'])->first();

            $user->update([
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'email' => $validated['email'],
                'phone_number' => $validated['phone_number'],
                'center_id' => $validated['center_id'],
                'city' => $selectedCenter->city, // Mettre à jour la ville selon le centre
                'validated_by' => Auth::id(),
                'validated_at' => now(),
                'finalized_by' => Auth::id(),
                'finalized_at' => now(),
            ]);

            // Mettre à jour les informations spécifiques à l'élève
            $user->student->update([
                'establishment' => $validated['establishment'],
                'parent_phone_number' => $validated['parent_phone_number'],
            ]);

            // Créer l'inscription principale
            $registration = Registration::create([
                'receipt_number' => $validated['receipt_number'],
                'contract' => $validated['contract_amount'],
                'special_conditions' => $validated['special_conditions'],

                'student_id' => $user->student->id,
                'center_id' => $validated['center_id'],
            ]);

            if (!empty($validated['formations'])) {
                $registration->formations()->sync($validated['formations']);
            }

            // Créer le premier versement si un montant a été reçu
            if ($validated['amount_received'] > 0) {
                $registration->installments()->create([
                    'amount' => $validated['amount_received'],

                    'payment_method_id' => $validated['payment_method_id'],
                    'registration_id' => $registration->id,

                    'processed_by' => Auth::id(),
                ]);
            }

            DB::commit();

            // Rediriger vers la page de confirmation
            return redirect()
                ->route('admin.finance.students.confirmation', [
                    'locale' => app()->getLocale(),
                    'registration' => $registration->id
                ])
                ->with('success', "L'inscription de {$student->full_name} a été finalisée avec succès!");

        } catch (\Exception $e) {
            DB::rollBack();

            return back()
                ->withInput()
                ->with('error', 'Une erreur est survenue lors de la finalisation de l\'inscription: ' . $e->getMessage());
        }
    }

    /**
     * Affiche la confirmation d'inscription
     */
    public function confirmationRegistration($locale, Registration $registration)
    {
        $registration->student->user->update([
            'status' => User::STATUS_ACTIVE,
        ]);

        $registration->load(['student.user', 'formations', 'center']);

        return view('admin.finance.students.confirm', compact('registration'));
    }

    /**
     * Rejette une inscription
     */
    public function rejectStudent(Request $request, $locale, User $student)
    {
        $validated = $request->validate([
            'rejection_reason' => 'required|string|max:1000',
        ]);

        $student->update([
            'status' => User::STATUS_REJECTED,
            'rejection_reason' => $validated['rejection_reason'],
            'validated_by' => Auth::id(),
            'validated_at' => now(),
        ]);

        return redirect()
            ->route('admin.finance.students.pending', ['locale' => app()->getLocale()])
            ->with('success', "L'inscription de {$student->full_name} a été rejetée.");
    }

    /**
     * Affiche les élèves avec inscriptions terminées
     */
    public function completedRegistrations(Request $request)
    {
        $query = Registration::with(['student.user', 'formations', 'center', 'paymentMethod'])
            ->latest();

        // Filtres
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('student.user', function($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('center_id')) {
            $query->where('center_id', $request->center_id);
        }

        $registrations = $query->paginate(15);

        $centers = Center::where('is_active', true)->orderBy('name')->get();

        return view('admin.finance.students.completed', compact('registrations', 'centers'));
    }
}
