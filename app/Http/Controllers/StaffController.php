<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Staff; // Modèle Staff
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Illuminate\Validation\Rules\Password;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;

class StaffController extends Controller
{
    public function __construct()
    {
        // Permissions (adaptez les noms)
        // $this->middleware('can:staff.view_any')->only('index');
        // $this->middleware('can:staff.view')->only('show');
        // $this->middleware('can:staff.create')->only(['create', 'store']);
        // $this->middleware('can:staff.update')->only(['edit', 'update']);
        // $this->middleware('can:staff.delete')->only('destroy');
        // $this->middleware('can:staff.manage_permissions')->only('updateDirectPermissions');
        // $this->middleware('can:staff.manage_staff_records')->only(['addStaffRecord', 'removeStaffRecord']); // Pour gérer les postes multiples
    }

    /**
     * Affiche la liste des membres du personnel.
     */
    public function index(Request $request)
    {
        // Auth::user()->can('staff.view_any'); // Vérification de permission

        $query = User::where('account_type', 'staff');

        if ($request->filled('role')) {
            $query->whereHas('roles', function($q) use ($request) {
                $q->where('name', $request->role);
            });
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone_number', 'like', "%{$search}%");
            });
        }

        // La relation s'appelle 'staff' dans votre modèle User.php
        $staffMembers = $query->with(['roles', 'staff'])->latest()->paginate(15);

        $roles = Role::whereNotIn('name', ['eleve', 'enseignant'])->get(); // Ajustez si vous avez une catégorie de rôle "staff"

        $stats = [
            'total' => User::where('account_type', 'staff')->count(),
            'active' => User::where('account_type', 'staff')->where('status', User::STATUS_ACTIVE)->count(),
        ];

        return view('admin.staff.index', compact('staffMembers', 'roles', 'stats'));
    }

    /**
     * Affiche le formulaire de création d'un membre du personnel.
     */
    public function create()
    {
        // Auth::user()->can('staff.create');

        $roles = Role::whereNotIn('name', ['eleve', 'enseignant'])->pluck('name', 'name');
        // $cities = City::pluck('name', 'id'); // Si vous utilisez city_id

        return view('admin.staff.create', compact('roles'/*, 'cities'*/));
    }

    /**
     * Enregistre un nouveau membre du personnel.
     */
    public function store(Request $request)
    {
        // Auth::user()->can('staff.create');

        $validatedUserData = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['nullable', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'phone_number' => ['nullable', 'string', 'max:20', 'unique:users,phone_number'],
            'city' => ['nullable', 'string', 'max:255'], // Ou 'city_id' => ['required', 'exists:cities,id'],
            'address' => ['nullable', 'string', 'max:255'],
            'password' => ['required', 'confirmed', Password::defaults()],
            'roles' => ['required', 'array'],
            'roles.*' => ['exists:roles,name', function ($attribute, $value, $fail) {
                if (in_array($value, ['eleve', 'enseignant'])) {
                    $fail("Le rôle {$value} n'est pas applicable au personnel.");
                }
            }],
            // Si vous aviez des champs pour la table 'staff' à la création, validez-les ici
            // 'job_title' => ['sometimes', 'required_if_creating_staff_record', 'string', 'max:255'],
        ]);

        DB::beginTransaction();
        try {
            $user = User::create([
                'first_name' => $validatedUserData['first_name'],
                'last_name' => $validatedUserData['last_name'],
                'email' => $validatedUserData['email'],
                'phone_number' => $validatedUserData['phone_number'],
                'city' => $validatedUserData['city'], // ou 'city_id'
                'address' => $validatedUserData['address'] ?? 'cradat',
                'password' => Hash::make($validatedUserData['password']),
                'account_type' => 'staff',
                'status' => User::STATUS_ACTIVE,
                'validated_by' => Auth::id(),
                'validated_at' => now(),
                'finalized_by' => Auth::id(),
                'finalized_at' => now(),
                'email_verified_at' => now(),
            ]);

            // Créer une entrée par défaut dans la table staff.
            // Si vous voulez ajouter des attributs ici (ex: un titre de poste par défaut),
            // le modèle Staff et la table staff devraient les avoir.
            $user->staff()->create([
                // 'job_title' => $validatedUserData['job_title'] ?? 'Poste par défaut', // Exemple
            ]);

            $user->syncRoles($validatedUserData['roles']);

            DB::commit();

            return redirect()->route('admin.staff.index', ['locale' => app()->getLocale()])
                ->with('success', 'Membre du personnel créé avec succès.');

        } catch (\Exception $e) {
            DB::rollBack();
            // Log::error("Erreur création staff: " . $e->getMessage() . $e->getTraceAsString());
            return back()->withInput()->with('error', 'Une erreur est survenue: ' . $e->getMessage());
        }
    }

    /**
     * Affiche les détails d'un membre du personnel (User).
     * Le paramètre $staffUser est une instance de User.
     */
    public function show($locale, User $staffUser) // Renommé en $staffUser pour clarté
    {
        if ($staffUser->account_type !== 'staff') {
            abort(404, "Ce profil utilisateur n'est pas un membre du personnel.");
        }
        // Auth::user()->can('staff.view', $staffUser);

        $staffUser->load(['roles', 'staff']); // 'staff' est la relation HasMany

        $allRoles = Role::whereNotIn('name', ['eleve', 'enseignant'])->get();
        $permissionsByModule = [];
        if (Auth::user() && Auth::user()->can('staff.manage_permissions', $staffUser)) { // Adaptez la permission
            $permissionsByModule = Permission::all()->groupBy('module');
        }

        // Dans la vue 'admin.staff.show', vous pourrez itérer sur $staffUser->staff
        // pour afficher les différents "postes" (enregistrements Staff).
        // Pour l'instant, ce sera juste une liste d'IDs ou de timestamps.
        return view('admin.staff.show', compact('staffUser', 'allRoles', 'permissionsByModule'));
    }

    /**
     * Affiche le formulaire de modification d'un membre du personnel (User).
     */
    public function edit($locale, User $staffUser)
    {
        if ($staffUser->account_type !== 'staff') {
            abort(404);
        }
        // Auth::user()->can('staff.update', $staffUser);

        $staffUser->load('staff'); // Charger les postes staff actuels

        $roles = Role::whereNotIn('name', ['eleve', 'enseignant'])->pluck('name', 'name');
        $statuses = [
            User::STATUS_ACTIVE => 'Actif',
            User::STATUS_SUSPENDED => 'Suspendu',
            User::STATUS_ARCHIVED => 'Archivé',
        ];

        // La vue 'admin.staff.edit' devra gérer l'affichage des informations User
        // et potentiellement une section pour gérer les postes staff si vous ajoutez cette fonctionnalité.
        return view('admin.staff.edit', compact('staffUser', 'roles', 'statuses'));
    }

    /**
     * Met à jour les informations d'un membre du personnel (User).
     */
    public function update(Request $request, $locale, User $staffUser)
    {
        if ($staffUser->account_type !== 'staff') {
            abort(404);
        }
        // Auth::user()->can('staff.update', $staffUser);

        $validatedUserData = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['nullable', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email,' . $staffUser->id],
            'phone_number' => ['nullable', 'string', 'max:20', 'unique:users,phone_number,' . $staffUser->id],
            'city' => ['nullable', 'string', 'max:255'], // ou 'city_id'
            'address' => ['nullable', 'string', 'max:255'],
            'password' => ['nullable', 'confirmed', Password::defaults()],
            'roles' => ['sometimes', 'array'],
            'roles.*' => ['exists:roles,name', function ($attribute, $value, $fail) {
                if (in_array($value, ['eleve', 'enseignant'])) {
                    $fail("Le rôle {$value} n'est pas applicable au personnel.");
                }
            }],
            'status' => ['required', 'in:' . implode(',', [User::STATUS_ACTIVE, User::STATUS_SUSPENDED, User::STATUS_ARCHIVED])],
            // Si vous permettez de modifier les attributs des postes staff existants ici,
            // la validation serait plus complexe (par exemple, un tableau de données de postes).
        ]);

        DB::beginTransaction();
        try {
            $userDataToUpdate = $request->only(['first_name', 'last_name', 'email', 'phone_number', 'city', 'address', 'status']);

            if (!empty($validatedUserData['password'])) {
                $userDataToUpdate['password'] = Hash::make($validatedUserData['password']);
            }
            $staffUser->update($userDataToUpdate);

            if (isset($validatedUserData['roles'])) {
                $staffUser->syncRoles($validatedUserData['roles']);
            }

            // La gestion de la mise à jour des enregistrements Staff multiples
            // (s'ils avaient des attributs modifiables) serait ici.
            // Exemple:
            // if ($request->has('staff_records')) {
            //     foreach ($request->staff_records as $staff_id => $staff_data) {
            //         $staffRecord = Staff::find($staff_id);
            //         if ($staffRecord && $staffRecord->user_id === $staffUser->id) {
            //             $staffRecord->update($staff_data); // Valider $staff_data
            //         }
            //     }
            // }

            DB::commit();

            return redirect()->route('admin.staff.show', ['locale' => app()->getLocale(), 'staffUser' => $staffUser->id])
                ->with('success', 'Informations du membre du personnel mises à jour.');

        } catch (\Exception $e) {
            DB::rollBack();
            // Log::error("Erreur màj staff: " . $e->getMessage() . $e->getTraceAsString());
            return back()->withInput()->with('error', 'Une erreur est survenue: ' . $e->getMessage());
        }
    }

    /**
     * Gère la mise à jour des permissions directes d'un membre du personnel.
     */
    public function updateDirectPermissions(Request $request, $locale, User $staffUser)
    {
        if ($staffUser->account_type !== 'staff') {
            abort(404);
        }
        // Auth::user()->can('staff.manage_permissions', $staffUser);

        $validated = $request->validate([
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        $permissions = $validated['permissions'] ?? [];
        $staffUser->syncPermissions($permissions);

        return redirect()->route('admin.staff.show', ['locale' => app()->getLocale(), 'staffUser' => $staffUser->id])
            ->with('success', 'Permissions directes mises à jour.');
    }

    /**
     * Supprime un membre du personnel (User).
     * Les enregistrements Staff associés seront supprimés en cascade.
     */
    public function destroy($locale, User $staffUser)
    {
        if ($staffUser->account_type !== 'staff') {
            abort(404);
        }
        // Auth::user()->can('staff.delete', $staffUser);

        if (Auth::id() === $staffUser->id) {
            return back()->with('error', 'Vous ne pouvez pas supprimer votre propre compte.');
        }

        DB::beginTransaction();
        try {
            $staffUser->delete(); // Cela déclenchera onDelete('cascade') pour la table 'staff'
            DB::commit();

            return redirect()->route('admin.staff.index', ['locale' => app()->getLocale()])
                ->with('success', 'Membre du personnel supprimé avec succès.');
        } catch (\Exception $e) {
            DB::rollBack();
            // Log::error("Erreur suppression staff: " . $e->getMessage());
            return back()->with('error', 'Une erreur est survenue lors de la suppression.');
        }
    }

    // --- Méthodes potentielles pour gérer les postes Staff multiples ---
    // Ces méthodes nécessiteraient des routes et des vues/formulaires dédiés.

    /**
     * Affiche le formulaire pour ajouter un nouveau poste (Staff record) à un User existant.
     */
    // public function createStaffRecordForm($locale, User $staffUser) { ... }

    /**
     * Ajoute un nouvel enregistrement Staff (poste) à un User existant.
     */
    // public function addStaffRecord(Request $request, $locale, User $staffUser) {
    //     // Auth::user()->can('staff.manage_staff_records', $staffUser);
    //     $validatedData = $request->validate([
    //         // 'job_title' => ['required', 'string', 'max:255'], // Si la table staff a ces champs
    //         // 'department_info' => ['nullable', 'string'],
    //     ]);
    //     $staffUser->staff()->create($validatedData);
    //     return back()->with('success', 'Nouveau poste ajouté.');
    // }

    /**
     * Supprime un enregistrement Staff (poste) spécifique d'un User.
     */
    // public function removeStaffRecord($locale, User $staffUser, Staff $staffRecord) { // $staffRecord est une instance de Staff
    //     // Auth::user()->can('staff.manage_staff_records', $staffUser);
    //     if ($staffRecord->user_id !== $staffUser->id) {
    //         abort(403, "Ce poste n'appartient pas à cet utilisateur.");
    //     }
    //     $staffRecord->delete();
    //     return back()->with('success', 'Poste supprimé.');
    // }
}