<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Teacher; // Modèle Teacher
use App\Models\Academy;
use App\Models\Department;
use App\Models\Center;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Illuminate\Validation\Rules\Password;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class TeacherController extends Controller
{
    public function __construct()
    {
        // Permissions
        // $this->middleware('can:teacher.view_any')->only('index');
        // $this->middleware('can:teacher.view')->only('show');
        // $this->middleware('can:teacher.create')->only(['create', 'store']);
        // $this->middleware('can:teacher.update')->only(['edit', 'update']);
        // $this->middleware('can:teacher.delete')->only('destroy');
        // $this->middleware('can:teacher.manage_permissions')->only('updateDirectPermissions');
    }

    /**
     * Affiche la liste des utilisateurs de type enseignant.
     */
    public function index(Request $request)
    {
        // Auth::user()->can('teacher.view_any');

        $query = User::where('account_type', 'teacher')->whereHas('teacherProfile'); // S'assurer qu'ils ont un profil enseignant

        if ($request->filled('role')) { // Filtrage par rôle Spatie
            $query->whereHas('roles', function($q) use ($request) {
                $q->where('name', $request->role);
            });
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('academy_id')) {
            $query->whereHas('teacherProfile', function($q) use ($request) {
                $q->where('academy_id', $request->academy_id);
            });
        }
        if ($request->filled('department_id')) {
            $query->whereHas('teacherProfile', function($q) use ($request) {
                $q->where('department_id', $request->department_id);
            });
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone_number', 'like', "%{$search}%")
                  ->orWhereHas('teacherProfile', function($subQ) use ($search){
                      $subQ->where('matricule', 'like', "%{$search}%")
                           ->orWhere('cni', 'like', "%{$search}%");
                  });
            });
        }

        // Charger avec 'teacherProfile' (HasOne) et ses relations
        $teacherUsers = $query->with(['roles', 'teacherProfile.academy', 'teacherProfile.departmentModel', 'teacherProfile.center'])
                               ->latest()
                               ->paginate(15);

        $spatieRoles = Role::where('name', 'enseignant')->get();
        $academies = Academy::orderBy('name')->pluck('name', 'id');
        $departments = Department::orderBy('name')->pluck('name', 'id');

        $stats = [
            'total' => User::where('account_type', 'teacher')->whereHas('teacherProfile')->count(),
            'active' => User::where('account_type', 'teacher')->whereHas('teacherProfile')->where('status', User::STATUS_ACTIVE)->count(),
        ];

        return view('admin.teachers.index', compact('teacherUsers', 'spatieRoles', 'academies', 'departments', 'stats'));
    }

    /**
     * Affiche le formulaire de création d'un utilisateur enseignant et de son profil.
     */
    public function create()
    {
        // Auth::user()->can('teacher.create');

        $spatieRoles = Role::where('name', 'enseignant')->pluck('name', 'name');
        $academies = Academy::orderBy('name')->pluck('name', 'id');
        $departments = Department::orderBy('name')->pluck('name', 'id');
        $centers = Center::orderBy('name')->pluck('name', 'id');
        // $cities = City::pluck('name', 'id');

        return view('admin.teachers.create', compact('spatieRoles', 'academies', 'departments', 'centers'/*, 'cities'*/));
    }

    /**
     * Enregistre un nouvel utilisateur enseignant et son profil Teacher.
     */
    public function store(Request $request)
    {
        // Auth::user()->can('teacher.create');

        $validatedData = $request->validate([
            // User fields
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['nullable', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'phone_number' => ['nullable', 'string', 'max:20', Rule::unique('users', 'phone_number')],
            'city' => ['nullable', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:255'],
            'password' => ['required', 'confirmed', Password::defaults()],
            'spatie_roles' => ['required', 'array'],
            'spatie_roles.*' => ['exists:roles,name', function ($attribute, $value, $fail) {
                if ($value !== 'enseignant' /* && autres rôles enseignants */) {
                    $fail("Le rôle {$value} n'est pas un rôle d'enseignant valide.");
                }
            }],

            // Teacher profile fields
            'matricule' => ['nullable', 'string', 'max:255', Rule::unique('teachers', 'matricule')],
            'salary' => ['nullable', 'numeric', 'min:0'],
            'cni' => ['nullable', 'string', 'max:255', Rule::unique('teachers', 'cni')],
            'birthdate' => ['nullable', 'date'],
            'birthplace' => ['nullable', 'string', 'max:255'],
            'profession' => ['nullable', 'string', 'max:255'],
            'department' => ['nullable', 'string', 'max:255'], // Champ texte libre
            'academy_id' => ['nullable', 'exists:academies,id'],
            'department_id' => ['nullable', 'exists:departments,id'], // FK
            'center_id' => ['nullable', 'exists:centers,id'],
        ]);

        DB::beginTransaction();
        try {
            $user = User::create([
                'first_name' => $validatedData['first_name'],
                'last_name' => $validatedData['last_name'],
                'email' => $validatedData['email'],
                'phone_number' => $validatedData['phone_number'],
                'city' => $validatedData['city'],
                'address' => $validatedData['address'] ?? 'cradat',
                'password' => Hash::make($validatedData['password']),
                'account_type' => 'teacher',
                'status' => User::STATUS_ACTIVE,
                'validated_by' => Auth::id(),
                'validated_at' => now(),
                'finalized_by' => Auth::id(),
                'finalized_at' => now(),
                'email_verified_at' => now(),
            ]);

            // Créer le profil Teacher associé (HasOne)
            $user->teacherProfile()->create([ // Utilise la relation teacherProfile() (HasOne)
                'matricule' => $validatedData['matricule'] ?? null,
                'salary' => $validatedData['salary'] ?? null,
                'cni' => $validatedData['cni'] ?? null,
                'birthdate' => $validatedData['birthdate'] ?? null,
                'birthplace' => $validatedData['birthplace'] ?? null,
                'profession' => $validatedData['profession'] ?? null,
                'department' => $validatedData['department'] ?? null,
                'academy_id' => $validatedData['academy_id'] ?? null,
                'department_id' => $validatedData['department_id'] ?? null,
                'center_id' => $validatedData['center_id'] ?? null,
            ]);

            $user->syncRoles($validatedData['spatie_roles']);

            DB::commit();

            return redirect()->route('admin.teachers.index', ['locale' => app()->getLocale()])
                ->with('success', 'Enseignant créé avec succès.');

        } catch (\Exception $e) {
            DB::rollBack();
            // Log::error("Erreur création enseignant: " . $e->getMessage() . "\n" . $e->getTraceAsString());
            return back()->withInput()->with('error', 'Une erreur est survenue: ' . $e->getMessage());
        }
    }

    /**
     * Affiche les détails d'un utilisateur enseignant et son profil.
     * $teacherUser est une instance de User.
     */
    public function show($locale, User $teacherUser)
    {
        if ($teacherUser->account_type !== 'teacher' || !$teacherUser->teacherProfile) { // Vérifier aussi l'existence du profil
            abort(404, "Profil enseignant non trouvé.");
        }
        // Auth::user()->can('teacher.view', $teacherUser);

        $teacherUser->load(['roles', 'teacherProfile.academy', 'teacherProfile.departmentModel', 'teacherProfile.center']);

        $spatieRoles = Role::where('name', 'enseignant')->orWhere(/* autres */)->get(); // Pour assigner/modifier
        $permissionsByModule = [];
        if (Auth::user() && Auth::user()->can('teacher.manage_permissions', $teacherUser)) {
            $permissionsByModule = Permission::all()->groupBy('module');
        }

        return view('admin.teachers.show', compact('teacherUser', 'spatieRoles', 'permissionsByModule'));
    }

    /**
     * Affiche le formulaire pour modifier les informations de l'utilisateur enseignant et son profil.
     */
    public function edit($locale, User $teacherUser)
    {
        if ($teacherUser->account_type !== 'teacher' || !$teacherUser->teacherProfile) {
            abort(404);
        }
        // Auth::user()->can('teacher.update', $teacherUser);

        $teacherUser->load('teacherProfile.academy', 'teacherProfile.departmentModel', 'teacherProfile.center');

        $spatieRoles = Role::where('name', 'enseignant')->pluck('name', 'name');
        $academies = Academy::orderBy('name')->pluck('name', 'id');
        $departments = Department::orderBy('name')->pluck('name', 'id');
        $centers = Center::orderBy('name')->pluck('name', 'id');
        $statuses = [User::STATUS_ACTIVE => 'Actif', User::STATUS_SUSPENDED => 'Suspendu', /* ... */];
        // $cities = City::pluck('name', 'id');

        return view('admin.teachers.edit', compact('teacherUser', 'spatieRoles', 'academies', 'departments', 'centers', 'statuses'/*, 'cities'*/));
    }

    /**
     * Met à jour les informations de l'utilisateur enseignant et de son profil Teacher.
     */
    public function update(Request $request, $locale, User $teacherUser)
    {
        if ($teacherUser->account_type !== 'teacher' || !$teacherUser->teacherProfile) {
            abort(404);
        }
        // Auth::user()->can('teacher.update', $teacherUser);

        $teacherProfile = $teacherUser->teacherProfile; // L'unique profil enseignant

        $validatedData = $request->validate([
            // User fields
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['nullable', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique('users', 'email')->ignore($teacherUser->id)],
            'phone_number' => ['nullable', 'string', 'max:20', Rule::unique('users', 'phone_number')->ignore($teacherUser->id)],
            'city' => ['nullable', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:255'],
            'password' => ['nullable', 'confirmed', Password::defaults()],
            'spatie_roles' => ['sometimes', 'array'],
            'spatie_roles.*' => ['exists:roles,name', /* ... validation rôle enseignant ... */],
            'status' => ['required', 'in:' . implode(',', [User::STATUS_ACTIVE, User::STATUS_SUSPENDED, /* ... */])],

            // Teacher profile fields
            'matricule' => ['nullable', 'string', 'max:255', Rule::unique('teachers', 'matricule')->ignore($teacherProfile->id)], // Ignore l'ID du profil actuel
            'salary' => ['nullable', 'numeric', 'min:0'],
            'cni' => ['nullable', 'string', 'max:255', Rule::unique('teachers', 'cni')->ignore($teacherProfile->id)],
            'birthdate' => ['nullable', 'date'],
            'birthplace' => ['nullable', 'string', 'max:255'],
            'profession' => ['nullable', 'string', 'max:255'],
            'department' => ['nullable', 'string', 'max:255'],
            'academy_id' => ['nullable', 'exists:academies,id'],
            'department_id' => ['nullable', 'exists:departments,id'],
            'center_id' => ['nullable', 'exists:centers,id'],
        ]);

        DB::beginTransaction();
        try {
            $userDataToUpdate = $request->only(['first_name', 'last_name', 'email', 'phone_number', 'city', 'address', 'status']);
            if (!empty($validatedData['password'])) {
                $userDataToUpdate['password'] = Hash::make($validatedData['password']);
            }
            $teacherUser->update($userDataToUpdate);

            if (isset($validatedData['spatie_roles'])) {
                $teacherUser->syncRoles($validatedData['spatie_roles']);
            }

            // Mettre à jour le profil Teacher
            $teacherProfileData = $request->only([
                'matricule', 'salary', 'cni', 'birthdate', 'birthplace', 'profession',
                'department', 'academy_id', 'department_id', 'center_id'
            ]);
            // Pour éviter d'écraser des champs par null si non fournis dans le form lors de la mise à jour partielle
            $teacherProfileData = array_filter($teacherProfileData, function($value) {
                return $value !== null;
            });

            if (!empty($teacherProfileData)) {
                $teacherProfile->update($teacherProfileData);
            }


            DB::commit();

            return redirect()->route('admin.teachers.show', ['locale' => app()->getLocale(), 'teacherUser' => $teacherUser->id])
                ->with('success', 'Informations de l\'enseignant mises à jour.');

        } catch (\Exception $e) {
            DB::rollBack();
            // Log::error("Erreur màj enseignant: " . $e->getMessage() . "\n" . $e->getTraceAsString());
            return back()->withInput()->with('error', 'Une erreur est survenue: ' . $e->getMessage());
        }
    }

    /**
     * Gère la mise à jour des permissions directes d'un enseignant.
     */
    public function updateDirectPermissions(Request $request, $locale, User $teacherUser)
    {
        if ($teacherUser->account_type !== 'teacher' || !$teacherUser->teacherProfile) {
            abort(404);
        }
        // Auth::user()->can('teacher.manage_permissions', $teacherUser);

        $validated = $request->validate([
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        $permissions = $validated['permissions'] ?? [];
        $teacherUser->syncPermissions($permissions);

        return redirect()->route('admin.teachers.show', ['locale' => app()->getLocale(), 'teacherUser' => $teacherUser->id])
            ->with('success', 'Permissions directes mises à jour.');
    }

    /**
     * Supprime un utilisateur enseignant. Son profil Teacher sera supprimé en cascade.
     */
    public function destroy($locale, User $teacherUser)
    {
        if ($teacherUser->account_type !== 'teacher' || !$teacherUser->teacherProfile) {
            abort(404);
        }
        // Auth::user()->can('teacher.delete', $teacherUser);

        if (Auth::id() === $teacherUser->id) {
            return back()->with('error', 'Vous ne pouvez pas supprimer votre propre compte.');
        }

        DB::beginTransaction();
        try {
            // La suppression du User déclenchera onDelete('cascade') pour le Teacher profile.
            $teacherUser->delete();
            DB::commit();

            return redirect()->route('admin.teachers.index', ['locale' => app()->getLocale()])
                ->with('success', 'Enseignant supprimé avec succès.');
        } catch (\Exception $e) {
            DB::rollBack();
            // Log::error("Erreur suppression enseignant: " . $e->getMessage());
            return back()->with('error', 'Une erreur est survenue lors de la suppression.');
        }
    }
}