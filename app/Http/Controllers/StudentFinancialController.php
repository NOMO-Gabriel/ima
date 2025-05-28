<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\EntranceExam;
use App\Models\Formation;
use App\Models\City;
use App\Models\Center;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentFinancialController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        // $this->authorize('finance.student.view'); // Autorisation de base pour accéder à la page

        $query = User::role('eleve')->with(['city', 'center', 'financialValidator', 'finalizedBy']);

        // Appliquer le scope de données en fonction des permissions/rôles
        // Le PCA voit tout par défaut car il a toutes les permissions.
        // Si un utilisateur n'est ni PCA, ni DF National, on applique des scopes plus restrictifs.
        if (!$user->hasRole('pca') && !$user->can('finance.student.filter.by_city')) { // DF National a filter.by_city
            if ($user->can('finance.student.filter.by_center') && $user->city_id) { // DF Ville a filter.by_center (pour sa ville)
                $query->where('users.city_id', $user->city_id);
            } elseif ($user->hasRole('resp-financier') && $user->center_id) { // Resp Financier
                $query->where('users.center_id', $user->center_id);
            } else {
                 // Si seulement 'finance.student.view' sans permissions de filtrage étendues,
                 // et pas resp-financier avec un centre, ne rien afficher.
                 // Cela peut arriver si un rôle custom a juste la perm de vue.
                $query->whereRaw('0 = 1');
            }
        }

        // Filtres
        if ($request->filled('status')) {
            $query->where('users.status', $request->status);
        }

        if ($request->filled('city_id') && $user->can('finance.student.filter.by_city')) {
            $query->where('users.city_id', $request->city_id);
        }

        if ($request->filled('center_id') && $user->can('finance.student.filter.by_center')) {
            // Si DF Ville, s'assurer que le centre est dans sa ville (ou le PCA/DF_National peuvent voir tous les centres)
            if ($user->hasRole('df-ville') && $user->city_id) {
                $center = Center::find($request->center_id);
                if ($center && $center->city_id == $user->city_id) {
                    $query->where('users.center_id', $request->center_id);
                }
                // else : le filtre de centre est ignoré si pas dans la ville du DF Ville
            } else { // PCA ou DF National
                 $query->where('users.center_id', $request->center_id);
            }
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('users.first_name', 'like', "%{$search}%")
                  ->orWhere('users.last_name', 'like', "%{$search}%")
                  ->orWhere('users.email', 'like', "%{$search}%")
                  ->orWhere('users.phone_number', 'like', "%{$search}%")
                  ->orWhere(function ($q2) use ($search) {
                      $q2->whereJsonContains('users.student_data->matricule', $search);
                  });
            });
        }

        $sortField = $request->input('sort', 'users.created_at');
        $sortDirection = $request->input('direction', 'desc');
        $allowedSorts = ['users.first_name', 'users.last_name', 'users.email', 'users.status', 'users.created_at', 'city_name', 'center_name'];

        if (in_array($sortField, $allowedSorts)) {
            if ($sortField === 'city_name') {
                $query->select('users.*')
                      ->join('cities', 'users.city_id', '=', 'cities.id')
                      ->orderBy('cities.name', $sortDirection);
            } elseif ($sortField === 'center_name') {
                $query->select('users.*')
                      ->leftJoin('centers', 'users.center_id', '=', 'centers.id')
                      ->orderBy('centers.name', $sortDirection);
            } else {
                $query->orderBy($sortField, $sortDirection);
            }
        } else {
            $query->orderBy('users.created_at', 'desc');
        }

        $students = $query->paginate(15)->withQueryString();
        $cities = City::orderBy('name')->get();
        $centersForFilter = collect();

        if ($user->can('finance.student.filter.by_city')) { // Implique PCA ou DF National
            $centersForFilter = Center::orderBy('name')->get();
        } elseif ($user->can('finance.student.filter.by_center') && $user->city_id) { // DF Ville
            $centersForFilter = Center::where('city_id', $user->city_id)->orderBy('name')->get();
        }
        $statuses = User::getStudentStatuses();

        return view('finance.students.index', compact('students', 'cities', 'centersForFilter', 'statuses', 'request'));
    }

    public function editFinancials($locale, $user)
    {
        $student = User::find($user);
        if (!$student) {
            abort(404, 'Élève non trouvé');
        }
        
        $currentUser = Auth::user();
        if (!$student->hasRole('eleve')) { 
            abort(404); 
        }

        // Vérifier si l'utilisateur a le droit de voir cet élève (scope basé sur le scope de l'index)
        // Cette vérification est simplifiée ici, en assumant que si on arrive ici,
        // l'index aurait permis de voir l'élève. Une vérification plus stricte pourrait être nécessaire
        // si on peut accéder à cette route directement sans passer par l'index.
        // Le PCA a tous les droits.
        $canAccessStudent = $currentUser->hasRole('pca') ||
                            ($currentUser->can('finance.student.filter.by_city')) || // DF National
                            ($currentUser->can('finance.student.filter.by_center') && $currentUser->city_id === $student->city_id) || // DF Ville
                            ($currentUser->hasRole('resp-financier') && $currentUser->center_id === $student->center_id); // Resp Financier

        if (!$canAccessStudent) {
            abort(403, "Vous n'avez pas accès aux informations de cet élève.");
        }

        // Déterminer les capacités d'édition basées sur les permissions
        $canEditDetails = $currentUser->can('finance.student.edit.details');
        $canEditContract = $currentUser->can('finance.student.edit.contract') &&
                           ($currentUser->hasRole('resp-financier') && $currentUser->center_id === $student->center_id); // Resp Financier de son centre

        // Le PCA a toutes les permissions d'édition ici
        if ($currentUser->hasRole('pca')) {
            $canEditDetails = true;
            $canEditContract = true;
        }

        if (!$canEditDetails && !$canEditContract) {
             abort(403, "Vous n'êtes pas autorisé à modifier ces informations.");
        }

        $entranceExams = EntranceExam::orderBy('name')->get();
        $formations = Formation::orderBy('name')->get();
        $studentData = $student->student_data ?? [];
        $studentExamsIds = collect($studentData['entrance_exams'] ?? [])->pluck('id')->toArray();
        $studentFormationId = $studentData['contract']['formation']['id'] ?? null;
        $contractAmount = $studentData['contract']['amount'] ?? null;
        $paymentSchedule = $studentData['contract']['payment_schedule'] ?? null;
        $contractStartDate = $studentData['contract']['start_date'] ?? null;
        $contractEndDate = $studentData['contract']['end_date'] ?? null;
        $specialConditions = $studentData['contract']['special_conditions'] ?? null;
        $cities = City::orderBy('name')->get();
        $allCenters = Center::with('city')->orderBy('name')->get();
        $statuses = User::getStudentStatuses();

        return view('finance.students.edit-financials', compact(
            'student', 'entranceExams', 'formations', 'cities', 'allCenters', 'statuses',
            'studentExamsIds', 'studentFormationId', 'contractAmount', 'paymentSchedule',
            'contractStartDate', 'contractEndDate', 'specialConditions',
            'canEditDetails', 'canEditContract'
        ));
    }

    public function updateFinancials(Request $request, $locale, $user)
    {
        $student = User::find($user);
        if (!$student) {
            abort(404, 'Élève non trouvé');
        }
        
        $currentUser = Auth::user();
        if (!$student->hasRole('eleve')) { 
            abort(404); 
        }

        $canEditDetails = $currentUser->can('finance.student.edit.details');
        $canEditContract = $currentUser->can('finance.student.edit.contract') &&
                           ($currentUser->hasRole('resp-financier') && $currentUser->center_id === $student->center_id);

        if ($currentUser->hasRole('pca')) { // PCA a tous les droits d'édition
            $canEditDetails = true;
            $canEditContract = true;
        }

        if (!$canEditDetails && !$canEditContract) {
            abort(403, "Action non autorisée.");
        }

        $rules = [];
        if ($canEditDetails) { // Si PCA ou a la perm 'edit.details'
            $rules = array_merge($rules, [
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'gender' => 'required|in:male,female',
                'email' => 'required|string|email|max:255|unique:users,email,' . $student->id,
                'phone_number' => 'required|string|max:20|unique:users,phone_number,' . $student->id,
                'parent_phone_number' => 'nullable|string|max:20',
                'city_id' => 'required|exists:cities,id',
                'center_id' => 'nullable|exists:centers,id',
                'address' => 'required|string|max:255',
                'establishment' => 'required|string|max:255',
                'status' => 'required|in:' . implode(',', array_keys(User::getStudentStatuses())),
            ]);
        }

        if ($canEditContract) { // Si PCA ou a la perm 'edit.contract' ET est le resp-financier du bon centre
             $rules = array_merge($rules, [
                'entrance_exams' => 'nullable|array',
                'entrance_exams.*' => 'exists:entrance_exams,id',
                'formation_id' => 'nullable|exists:formations,id',
                'contract_amount' => 'nullable|numeric|min:0',
                'payment_schedule' => 'nullable|string|in:monthly,quarterly,semester,annual',
                'start_date' => 'nullable|date|date_format:Y-m-d',
                'end_date' => 'nullable|date|date_format:Y-m-d|after_or_equal:start_date',
                'special_conditions' => 'nullable|string|max:1000',
            ]);
        }

        if (empty($rules)) { // Devrait être attrapé par l'abort précédent, mais double sécurité
            abort(403, "Aucune action d'édition autorisée.");
        }

        $validatedData = $request->validate($rules);
        $studentData = $student->student_data ?? [];

        if ($canEditDetails) {
            $student->fill([
                'first_name' => strtoupper($validatedData['first_name']),
                'last_name' => strtoupper($validatedData['last_name']),
                'gender' => $validatedData['gender'] ?? $student->gender,
                'email' => $validatedData['email'],
                'phone_number' => $validatedData['phone_number'],
                'parent_phone_number' => $validatedData['parent_phone_number'] ?? null,
                'city_id' => $validatedData['city_id'],
                'center_id' => $validatedData['center_id'] ?? null,
                'address' => $validatedData['address'],
                'establishment' => $validatedData['establishment'],
            ]);
        }

        if ($canEditContract) {
            if (array_key_exists('entrance_exams', $validatedData)) {
                 $selectedExamsModels = EntranceExam::whereIn('id', $validatedData['entrance_exams'] ?? [])->get();
                 $studentData['entrance_exams'] = $selectedExamsModels->map(fn($exam) => ['id' => $exam->id, 'name' => $exam->name, 'code' => $exam->code])->toArray();
            }
            if (array_key_exists('formation_id', $validatedData) && !empty($validatedData['formation_id'])) {
                $formationModel = Formation::find($validatedData['formation_id']);
                $studentData['contract']['formation'] = ['id' => $formationModel->id, 'name' => $formationModel->name];
            } elseif (array_key_exists('formation_id', $validatedData) && empty($validatedData['formation_id'])) {
                 $studentData['contract']['formation'] = null;
            }

            if (array_key_exists('contract_amount', $validatedData)) $studentData['contract']['amount'] = $validatedData['contract_amount'] ?? null;
            if (array_key_exists('payment_schedule', $validatedData)) $studentData['contract']['payment_schedule'] = $validatedData['payment_schedule'] ?? null;
            if (array_key_exists('start_date', $validatedData)) $studentData['contract']['start_date'] = $validatedData['start_date'] ?? null;
            if (array_key_exists('end_date', $validatedData)) $studentData['contract']['end_date'] = $validatedData['end_date'] ?? null;
            if (array_key_exists('special_conditions', $validatedData)) $studentData['contract']['special_conditions'] = $validatedData['special_conditions'] ?? null;

            $contractInfoProvided = !empty($validatedData['formation_id']) || isset($validatedData['contract_amount']);
            if ($contractInfoProvided) {
                 $studentData['contract']['last_updated_by'] = Auth::id();
                 $studentData['contract']['last_updated_at'] = now()->toIso8601String();
                 if (!isset($studentData['contract']['assigned_by'])) {
                    $studentData['contract']['assigned_by'] = Auth::id();
                    $studentData['contract']['assigned_by_name'] = Auth::user()->full_name;
                    $studentData['contract']['assigned_at'] = now()->toISOString();
                 }
            }
        }
        $student->student_data = $studentData;

        // Gestion du statut (uniquement si l'utilisateur peut éditer les détails ou est PCA)
        if ($canEditDetails) { // $canEditDetails est vrai pour PCA aussi
            $oldStatus = $student->status;
            // 'status' sera dans $validatedData car il est 'required' si $canEditDetails est vrai
            $newStatus = $validatedData['status'];

            if ($newStatus !== $oldStatus) {
                if ($oldStatus === User::STATUS_PENDING_VALIDATION && $newStatus === User::STATUS_PENDING_CONTRACT) {
                    if (!$student->financial_validator_id) {
                        $student->financial_validator_id = Auth::id();
                        $student->financial_validation_date = now();
                    }
                } elseif ($newStatus === User::STATUS_ACTIVE && $currentUser->can('finance.student.activate')) {
                    if (empty($student->center_id)) {
                        return back()->withInput()->with('error', "Un centre doit être assigné pour activer l'élève.");
                    }
                    // Si le contrat est modifiable par l'utilisateur actuel, on vérifie les données du contrat.
                    // Sinon, on suppose que les données du contrat sont déjà là et valides (mises par un autre utilisateur).
                    if ($canEditContract) {
                        if (empty($studentData['entrance_exams']) || empty($studentData['contract']['formation']) || !isset($studentData['contract']['amount'])) {
                            return back()->withInput()->with('error', "Impossible d'activer l'élève. Les informations de concours, formation et montant du contrat sont requises.");
                        }
                    } else { // Si on ne peut pas éditer le contrat, il doit déjà être défini
                         if (empty($studentData['entrance_exams']) || empty($studentData['contract']['formation']) || !isset($studentData['contract']['amount'])) {
                            return back()->withInput()->with('error', "Impossible d'activer l'élève. Le contrat n'a pas encore été défini (ou les permissions sont insuffisantes pour le vérifier).");
                        }
                    }

                    if (!$student->financial_validator_id) {
                        $student->financial_validator_id = Auth::id();
                        $student->financial_validation_date = now();
                    }
                    if (!$student->finalized_by_id) {
                        $student->finalized_by_id = Auth::id();
                        $student->finalized_at = now();
                    }
                } elseif ($newStatus === User::STATUS_REJECTED && $currentUser->can('finance.student.reject')) {
                     $student->rejection_reason = $request->input('rejection_reason', 'Raison non spécifiée');
                }
                 $student->status = $newStatus;
            }
        }
        $student->save();

        return redirect()->route('finance.students.index', ['locale' => app()->getLocale()])
            ->with('success', 'Informations de l\'élève mises à jour avec succès.');
    }
}