<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    /**
     * Affiche la liste des utilisateurs
     */
    public function index(Request $request)
    {
        // Vérifier les permissions
        if (!auth()->user()->can('user.view.any')) {
            abort(403, 'Non autorisé');
        }

        // Filtrage des utilisateurs
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
        
        // Récupération des utilisateurs paginés
        $users = $query->latest()->paginate(10);
        
        // Récupération des rôles pour le filtre
        $roles = Role::all();
        
        return view('admin.users.index', compact('users', 'roles'));
    }

    /**
     * Affiche le formulaire de création d'un utilisateur
     */
    public function create()
    {
        // Vérifier les permissions
        if (!auth()->user()->can('user.create')) {
            abort(403, 'Non autorisé');
        }
        
        $roles = Role::all();
        return view('admin.users.create', compact('roles'));
    }

    /**
     * Enregistre un nouvel utilisateur
     */
    public function store(Request $request)
    {
        // Vérifier les permissions
        if (!auth()->user()->can('user.create')) {
            abort(403, 'Non autorisé');
        }
        
        // Validation des données
        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'phone_number' => ['required', 'string', 'max:20', 'unique:users,phone_number'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'roles' => ['required', 'array'],
            'status' => ['required', 'string', 'in:pending_validation,pending_finalization,active,suspended,rejected,archived'],
        ]);
        
        // Création de l'utilisateur
        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'city' => $request->city,
            'address' => $request->address,
            'password' => Hash::make($request->password),
            'status' => $request->status,
            'validated_by' => auth()->id(),
            'validated_at' => now(),
        ]);
        
        // Assignation des rôles
        $user->syncRoles($request->roles);
        
        return redirect()->route('admin.users.index')
            ->with('success', 'Utilisateur créé avec succès.');
    }

    /**
     * Affiche les détails d'un utilisateur
     */
    public function show(User $user)
    {
        // Vérifier les permissions
        if (!auth()->user()->can('user.view.any') && auth()->id() !== $user->id) {
            abort(403, 'Non autorisé');
        }
        
        return view('admin.users.show', compact('user'));
    }

    /**
     * Affiche le formulaire de modification d'un utilisateur
     */
    public function edit(User $user)
    {
        // Vérifier les permissions
        if (!auth()->user()->can('user.update.any') && auth()->id() !== $user->id) {
            abort(403, 'Non autorisé');
        }
        
        $roles = Role::all();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Met à jour un utilisateur
     */
    public function update(Request $request, User $user)
    {
        // Vérifier les permissions
        if (!auth()->user()->can('user.update.any') && auth()->id() !== $user->id) {
            abort(403, 'Non autorisé');
        }
        
        // Validation des données
        $rules = [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'phone_number' => ['required', 'string', 'max:20', 'unique:users,phone_number,' . $user->id],
            'city' => ['nullable', 'string', 'max:100'],
            'address' => ['nullable', 'string', 'max:255'],
        ];
        
        // Si l'utilisateur modifie le mot de passe
        if ($request->filled('password')) {
            $rules['password'] = ['required', 'confirmed', Rules\Password::defaults()];
        }
        
        // Si l'utilisateur a la permission de modifier les rôles
        if (auth()->user()->can('user.role.assign')) {
            $rules['roles'] = ['required', 'array'];
            $rules['status'] = ['required', 'string', 'in:pending_validation,pending_finalization,active,suspended,rejected,archived'];
        }
        
        $request->validate($rules);
        
        // Mise à jour des informations de base
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->phone_number = $request->phone_number;
        $user->city = $request->city;
        $user->address = $request->address;
        
        // Mise à jour du mot de passe si fourni
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        
        // Mise à jour du statut et des rôles si l'utilisateur a les permissions
        if (auth()->user()->can('user.role.assign')) {
            $user->status = $request->status;
            $user->syncRoles($request->roles);
            
            // Si l'utilisateur est validé pour la première fois
            if ($user->isDirty('status') && $user->status === 'active' && !$user->validated_at) {
                $user->validated_by = auth()->id();
                $user->validated_at = now();
                $user->finalized_by = auth()->id();
                $user->finalized_at = now();
            }
        }
        
        $user->save();
        
        return redirect()->route('admin.users.index')
            ->with('success', 'Utilisateur mis à jour avec succès.');
    }

    /**
     * Supprime un utilisateur
     */
    public function destroy(User $user)
    {
        // Vérifier les permissions
        if (!auth()->user()->can('user.delete.any')) {
            abort(403, 'Non autorisé');
        }
        
        // Empêcher la suppression de l'utilisateur connecté
        if (auth()->id() === $user->id) {
            return back()->with('error', 'Vous ne pouvez pas supprimer votre propre compte par cette méthode.');
        }
        
        $user->delete();
        
        return redirect()->route('admin.users.index')
            ->with('success', 'Utilisateur supprimé avec succès.');
    }
}