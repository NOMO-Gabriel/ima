<?php

namespace App\Http\Controllers; // Ou App\Http\Controllers\ suivant votre structure

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Student; // Modèle Student
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Illuminate\Validation\Rules\Password;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class StudentController extends Controller
{
    public function __construct()
    {
        // Permissions (adaptez les noms)
        // $this->middleware('can:student.view_any')->only('index');
        // $this->middleware('can:student.view')->only('show');
        // $this->middleware('can:student.create')->only(['create', 'store']); // La création d'étudiants se fait souvent par inscription, mais un admin peut avoir besoin de le faire
        // $this->middleware('can:student.update')->only(['edit', 'update']);
        // $this->middleware('can:student.delete')->only('destroy');
        // $this->middleware('can:student.manage_permissions')->only('updateDirectPermissions');
    }

    /**
     * Affiche la liste des utilisateurs de type étudiant.
     */
    public function index(Request $request)
    {
        // Auth::user()->can('student.view_any');

        $query = User::where('account_type', 'student')->whereHas('student'); // S'assurer qu'ils ont un profil étudiant

        if ($request->filled('role')) { // Filtrage par rôle Spatie (si applicable aux étudiants)
            $query->whereHas('roles', function($q) use ($request) {
                $q->where('name', $request->role);
            });
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        // Filtre spécifique aux étudiants
        if ($request->filled('establishment')) {
            $query->whereHas('student', function($q) use ($request) {
                $q->where('establishment', 'like', '%' . $request->establishment . '%');
            });
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone_number', 'like', "%{$search}%") // Numéro de l'étudiant
                  ->orWhereHas('student', function($subQ) use ($search){
                      $subQ->where('parent_phone_number', 'like', "%{$search}%"); // Numéro du parent
                  });
            });
        }

        $studentUsers = $query->with(['roles', 'student']) // 'student' est la relation HasOne
                               ->latest()
                               ->paginate(15);

        // Rôle Spatie 'eleve'
        $spatieRoles = Role::where('name', 'eleve')->get();
        $statuses = User::select('status')->distinct()->pluck('status')->mapWithKeys(fn ($status) => [$status => ucfirst(str_replace('_', ' ', $status))]);


        $stats = [
            'total' => User::where('account_type', 'student')->whereHas('student')->count(),
            'active' => User::where('account_type', 'student')->whereHas('student')->where('status', User::STATUS_ACTIVE)->count(),
            'pending_validation' => User::where('account_type', 'student')->whereHas('student')->where('status', User::STATUS_PENDING_VALIDATION)->count(),
            'pending_contract' => User::where('account_type', 'student')->whereHas('student')->where('status', User::STATUS_PENDING_CONTRACT)->count(),
        ];

        return view('admin.students.index', compact('studentUsers', 'spatieRoles', 'statuses', 'stats'));
    }

    /**
     * Affiche le formulaire de création d'un utilisateur étudiant et de son profil.
     * Note: Normalement, les étudiants s'inscrivent. Cette fonction est pour la création manuelle par un admin.
     */
    public function create()
    {
        // Auth::user()->can('student.create');

        // Le rôle 'eleve' est généralement assigné automatiquement.
        // Si l'admin le crée, on peut le présélectionner.
        $spatieRoleEleve = Role::where('name', 'eleve')->first();
        // $cities = City::pluck('name', 'id');

        return view('admin.students.create', compact('spatieRoleEleve'/*, 'cities'*/));
    }

    /**
     * Enregistre un nouvel utilisateur étudiant et son profil Student.
     */
    public function store(Request $request)
    {
        // Auth::user()->can('student.create');

        $validatedData = $request->validate([
            // User fields
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['nullable', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'phone_number' => ['nullable', 'string', 'max:20', Rule::unique('users', 'phone_number')],
            'city' => ['nullable', 'string', 'max:255'], // ou 'city_id'
            'address' => ['nullable', 'string', 'max:255'],
            'password' => ['required', 'confirmed', Password::defaults()],
            // Le rôle 'eleve' sera probablement assigné par défaut
            // 'spatie_roles' => ['sometimes', 'array'],
            // 'spatie_roles.*' => [Rule::in(['eleve'])], // S'assurer que seul le rôle élève est assignable ici

            // Student profile fields
            'establishment' => ['nullable', 'string', 'max:255'],
            'parent_phone_number' => ['nullable', 'string', 'max:20', Rule::unique('students', 'parent_phone_number')],
            // Autres champs User spécifiques aux étudiants du modèle User
            'wanted_entrance_exams' => ['nullable', 'array'],
        ]);

        DB::beginTransaction();
        try {
            $user = User::create([
                'first_name' => $validatedData['first_name'],
                'last_name' => $validatedData['last_name'],
                'email' => $validatedData['email'],
                'phone_number' => $validatedData['phone_number'],
                'city' => $validatedData['city'], // ou 'city_id'
                'address' => $validatedData['address'] ?? 'cradat',
                'password' => Hash::make($validatedData['password']),
                'account_type' => 'student', // Fixe pour StudentController
                // Statut par défaut pour un étudiant créé par un admin.
                // Si l'inscription publique met 'pending_validation', ici ça pourrait être 'active' ou 'pending_contract'.
                'status' => $request->status ?? User::STATUS_PENDING_VALIDATION, // ou User::STATUS_ACTIVE si créé par admin
                'validated_by' => ($request->status === User::STATUS_ACTIVE || $request->status === User::STATUS_PENDING_CONTRACT) ? Auth::id() : null,
                'validated_at' => ($request->status === User::STATUS_ACTIVE || $request->status === User::STATUS_PENDING_CONTRACT) ? now() : null,
                // 'finalized_by' et 'finalized_at' peuvent être définis plus tard dans le workflow
                'email_verified_at' => now(), // Ou laisser null pour vérification par email
                'wanted_entrance_exams' => $validatedData['wanted_entrance_exams'] ?? null,
            ]);

            // Créer le profil Student associé (HasOne)
            $user->student()->create([ // Utilise la relation student() (HasOne)
                'establishment' => $validatedData['establishment'] ?? null,
                'parent_phone_number' => $validatedData['parent_phone_number'] ?? null,
            ]);

            // Assigner le rôle 'eleve'
            $studentRole = Role::where('name', 'eleve')->first();
            if ($studentRole) {
                $user->assignRole($studentRole);
            }

            DB::commit();

            return redirect()->route('admin.students.index', ['locale' => app()->getLocale()])
                ->with('success', 'Étudiant créé avec succès.');

        } catch (\Exception $e) {
            DB::rollBack();
            // Log::error("Erreur création étudiant: " . $e->getMessage() . "\n" . $e->getTraceAsString());
            return back()->withInput()->with('error', 'Une erreur est survenue: ' . $e->getMessage());
        }
    }

    /**
     * Affiche les détails d'un utilisateur étudiant et son profil.
     * $studentUser est une instance de User.
     */
    public function show($locale, User $studentUser)
    {
        if ($studentUser->account_type !== 'student' || !$studentUser->student) {
            abort(404, "Profil étudiant non trouvé.");
        }
        // Auth::user()->can('student.view', $studentUser);

        $studentUser->load(['roles', 'student', 'validator', 'finalizer']); // Charger le profil et autres relations
                                                                        // 'validator' et 'finalizer' sont des relations BelongsTo User
        $permissionsByModule = [];
        // Les étudiants n'ont généralement pas de permissions directes assignables par l'admin de cette manière.
        // Mais si c'est le cas :
        // if (Auth::user() && Auth::user()->can('student.manage_permissions', $studentUser)) {
        //     $permissionsByModule = Permission::all()->groupBy('module');
        // }

        return view('admin.students.show', compact('studentUser', /*'permissionsByModule'*/));
    }

    /**
     * Affiche le formulaire pour modifier les informations de l'utilisateur étudiant et son profil.
     */
    public function edit($locale, User $studentUser)
    {
        if ($studentUser->account_type !== 'student' || !$studentUser->student) {
            abort(404);
        }
        // Auth::user()->can('student.update', $studentUser);

        $studentUser->load('student');

        $statuses = [ // Ou récupérez dynamiquement depuis le modèle User si possible
            User::STATUS_PENDING_VALIDATION => 'En attente de validation',
            User::STATUS_PENDING_CONTRACT => 'En attente de contrat/concours',
            User::STATUS_ACTIVE => 'Actif',
            User::STATUS_SUSPENDED => 'Suspendu',
            User::STATUS_REJECTED => 'Rejeté',
            User::STATUS_ARCHIVED => 'Archivé',
        ];
        // $cities = City::pluck('name', 'id');

        return view('admin.students.edit', compact('studentUser', 'statuses'/*, 'cities'*/));
    }

    /**
     * Met à jour les informations de l'utilisateur étudiant et de son profil Student.
     */
    public function update(Request $request, $locale, User $studentUser)
    {
        if ($studentUser->account_type !== 'student' || !$studentUser->student) {
            abort(404);
        }
        // Auth::user()->can('student.update', $studentUser);

        $studentProfile = $studentUser->student;

        $validatedData = $request->validate([
            // User fields
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['nullable', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique('users', 'email')->ignore($studentUser->id)],
            'phone_number' => ['nullable', 'string', 'max:20', Rule::unique('users', 'phone_number')->ignore($studentUser->id)],
            'city' => ['nullable', 'string', 'max:255'], // ou 'city_id'
            'address' => ['nullable', 'string', 'max:255'],
            'password' => ['nullable', 'confirmed', Password::defaults()], // Mot de passe optionnel à la MàJ
            'status' => ['required', Rule::in([
                User::STATUS_PENDING_VALIDATION, User::STATUS_PENDING_CONTRACT, User::STATUS_ACTIVE,
                User::STATUS_SUSPENDED, User::STATUS_REJECTED, User::STATUS_ARCHIVED
            ])],
            // Champs User spécifiques aux étudiants
            'wanted_entrance_exams' => ['nullable', 'array'],
            'contract_details' => ['nullable', 'array'], // Si modifiable ici
            'rejection_reason' => ['nullable', 'string', 'required_if:status,' . User::STATUS_REJECTED],


            // Student profile fields
            'establishment' => ['nullable', 'string', 'max:255'],
            'parent_phone_number' => ['nullable', 'string', 'max:20', Rule::unique('students', 'parent_phone_number')->ignore($studentProfile->id)],
        ]);

        DB::beginTransaction();
        try {
            $userDataToUpdate = $request->only([
                'first_name', 'last_name', 'email', 'phone_number', 'city', 'address', 'status',
                'wanted_entrance_exams', 'contract_details', 'rejection_reason'
            ]);

            if (!empty($validatedData['password'])) {
                $userDataToUpdate['password'] = Hash::make($validatedData['password']);
            }

            // Logique de validation/finalisation si le statut change
            if ($request->status === User::STATUS_ACTIVE && !$studentUser->finalized_at) {
                if (!$studentUser->validated_at) {
                    $userDataToUpdate['validated_by'] = Auth::id();
                    $userDataToUpdate['validated_at'] = now();
                }
                $userDataToUpdate['finalized_by'] = Auth::id();
                $userDataToUpdate['finalized_at'] = now();
            } elseif ($request->status === User::STATUS_PENDING_CONTRACT && !$studentUser->validated_at) {
                $userDataToUpdate['validated_by'] = Auth::id();
                $userDataToUpdate['validated_at'] = now();
            }


            $studentUser->update($userDataToUpdate);

            // Mettre à jour le profil Student
            $studentProfileData = $request->only(['establishment', 'parent_phone_number']);
            $studentProfileData = array_filter($studentProfileData, fn($value) => $value !== null);

            if(!empty($studentProfileData)) {
                $studentProfile->update($studentProfileData);
            }


            DB::commit();

            return redirect()->route('admin.students.show', ['locale' => app()->getLocale(), 'studentUser' => $studentUser->id])
                ->with('success', 'Informations de l\'étudiant mises à jour.');

        } catch (\Exception $e) {
            DB::rollBack();
            // Log::error("Erreur màj étudiant: " . $e->getMessage() . "\n" . $e->getTraceAsString());
            return back()->withInput()->with('error', 'Une erreur est survenue: ' . $e->getMessage());
        }
    }

    /**
     * Supprime un utilisateur étudiant. Son profil Student sera supprimé en cascade.
     */
    public function destroy($locale, User $studentUser)
    {
        if ($studentUser->account_type !== 'student' || !$studentUser->student) {
            abort(404);
        }
        // Auth::user()->can('student.delete', $studentUser);

        if (Auth::id() === $studentUser->id) {
            // Techniquement, un étudiant ne devrait pas pouvoir se supprimer via l'admin panel.
            // Et un admin ne devrait pas être un étudiant.
            return back()->with('error', 'Action non autorisée.');
        }

        DB::beginTransaction();
        try {
            $studentUser->delete(); // onDelete('cascade') s'occupera du profil Student
            DB::commit();

            return redirect()->route('admin.students.index', ['locale' => app()->getLocale()])
                ->with('success', 'Étudiant supprimé avec succès.');
        } catch (\Exception $e) {
            DB::rollBack();
            // Log::error("Erreur suppression étudiant: " . $e->getMessage());
            return back()->with('error', 'Une erreur est survenue lors de la suppression.');
        }
    }

    // Les étudiants n'ont généralement pas de permissions directes à assigner via ce type de CRUD.
    // La méthode updateDirectPermissions n'est donc probablement pas nécessaire ici.
}