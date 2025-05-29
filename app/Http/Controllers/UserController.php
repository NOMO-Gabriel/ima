<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Validation\Rules\Password;
use Spatie\Permission\Models\Permission;

class UserController extends Controller
{
    /**
     * Affiche le formulaire de création d'un utilisateur
     * Note: Seuls les enseignants et personnel peuvent être créés manuellement
     */
    public function create()
    {
        if ($this->user && !$this->user->can('user.create')) {
            abort(403, 'Non autorisé');
        }

        // Exclure le rôle 'eleve' des options disponibles
        $roles = Role::where('name', '!=', 'eleve')->get();

        return view('admin.users.create', compact('roles'));
    }

    /**
     * Enregistre un nouvel utilisateur
     * Note: Seuls les enseignants et personnel peuvent être créés manuellement
     */
    public function store(Request $request)
    {
        if ($this->user && !$this->user->can('user.create')) {
            abort(403, 'Non autorisé');
        }

        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'phone_number' => ['required', 'string', 'max:20', 'unique:users,phone_number'],
            'city_id' => ['required', 'exists:cities,id'],
            'password' => ['required', 'confirmed', Password::defaults()],
            'roles' => ['required', 'array'],
            'roles.*' => ['exists:roles,name', 'not_in:eleve'], // Interdire le rôle élève
        ]);

        // Vérifier qu'aucun rôle élève n'est sélectionné
        if (in_array('eleve', $request->roles)) {
            return back()->withErrors(['roles' => 'Les élèves ne peuvent pas être créés manuellement. Ils doivent s\'inscrire via le formulaire d\'inscription.']);
        }

        // Déterminer le account_type basé sur le premier rôle
        $accountType = $request->roles[0];

        // Création de l'utilisateur
        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'city_id' => $request->city_id,
            'address' => $request->address,
            'password' => Hash::make($request->password),
            'account_type' => $accountType,
            'status' => User::STATUS_ACTIVE, // Les comptes créés manuellement sont directement actifs
            'validated_by' => $this->user->id,
            'validated_at' => now(),
            'finalized_by' => $this->user->id,
            'finalized_at' => now(),
        ]);

        // Assignation des rôles
        $user->syncRoles($request->roles);

        return redirect()->route('admin.users.index', ['locale' => app()->getLocale()])
            ->with('success', 'Utilisateur créé avec succès.');
    }

    /**
     * Affiche la liste des utilisateurs avec filtres améliorés
     */
    public function index(Request $request)
    {
        $query = User::query();

        // Filtrage par rôle si fourni
        if ($request->filled('role')) {
            $query->whereHas('roles', function($q) use ($request) {
                $q->where('name', $request->role);
            });
        }

        // Filtrage par statut si fourni
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filtrage par type de compte
        if ($request->filled('account_type')) {
            $query->where('account_type', $request->account_type);
        }

        // Recherche par texte
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone_number', 'like', "%{$search}%");
            });
        }

        $users = $query->with(['roles'])->latest()->paginate(15);
        $roles = Role::all();

        // Statistiques pour le dashboard
        $stats = [
            'total' => User::count(),
            'active' => User::where('status', User::STATUS_ACTIVE)->count(),
            'pending_validation' => User::where('status', User::STATUS_PENDING_VALIDATION)->count(),
            'pending_contract' => User::where('status', User::STATUS_PENDING_CONTRACT)->count(),
            'students' => User::where('account_type', 'eleve')->count(),
            'teachers' => User::where('account_type', 'enseignant')->count(),
        ];

        return view('admin.users.index', compact('users', 'roles', 'stats'));
    }

    /**
     * Affiche les détails d'un utilisateur avec informations détaillées pour les élèves
     */
    public function show($locale, User $user)
    {

        // Charger les relations nécessaires
        $user->load(['roles']);

        // Récupérer les rôles si l'utilisateur peut les modifier
        $roles = $this->user->can('user.role.assign') ? Role::all() : collect();

        // Les permissions regroupées par module
        $permissionsByModule = [];
        if ($this->user && $this->user->can('user.role.assign')) {
            $permissionsByModule = Permission::all()->groupBy('module');
        }

        return view('admin.users.show', compact('user', 'roles', 'permissionsByModule'));
    }

    /**
     * Met à jour les rôles et permissions d'un utilisateur
     */
    public function updateRoles(Request $request, User $user)
    {
        // Vérifier les permissions
        if ($this->user && !$this->user->can('user.role.assign')) {
            abort(403, 'Non autorisé');
        }

        // Validation des données
        $validated = $request->validate([
            'roles' => 'nullable|array',
            'roles.*' => ['exists:roles,name'],
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id',
            'status' => 'required|in:pending_validation,pending_contract,active,suspended,rejected,archived',
        ]);

        // Empêcher la modification du rôle élève via cette méthode
        if (isset($validated['roles']) && in_array('eleve', $validated['roles']) && $user->account_type !== 'eleve') {
            return back()->withErrors(['roles' => 'Le rôle élève ne peut pas être assigné manuellement.']);
        }

        // Mise à jour du statut
        $user->status = $validated['status'];

        // Gestion de la validation/finalisation automatique si passage à actif
        if ($validated['status'] === User::STATUS_ACTIVE && !$user->validated_at) {
            $user->validated_by = $this->user->id;
            $user->validated_at = now();
            $user->finalized_by = $this->user->id;
            $user->finalized_at = now();
        }

        $user->save();

        // Mise à jour des rôles (seulement si ce n'est pas un élève)
        if (isset($validated['roles']) && $user->account_type !== 'eleve') {
            $user->syncRoles($validated['roles']);
        }

        // Mise à jour des permissions directes
        $permissions = isset($validated['permissions']) ? $validated['permissions'] : [];
        $user->syncPermissions($permissions);

        return redirect()->route('admin.users.show', ['locale' => app()->getLocale(), 'user' => $user])
            ->with('success', 'Rôles et permissions mis à jour avec succès');
    }

    /**
     * Supprime un utilisateur
     */
    public function destroy(User $user)
    {
        // Vérifier les permissions
        if ($this->user && !$this->user->can('user.delete.any')) {
            abort(403, 'Non autorisé');
        }

        // Empêcher la suppression de l'utilisateur connecté
        if ($this->user->id === $user->id) {
            return back()->with('error', 'Vous ne pouvez pas supprimer votre propre compte par cette méthode.');
        }

        $user->delete();

        return redirect()->route('admin.users.index', ['locale' => app()->getLocale()])
            ->with('success', 'Utilisateur supprimé avec succès.');
    }
}
