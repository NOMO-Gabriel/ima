<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;

class ProfileController extends Controller
{
    /**
     * Afficher le formulaire d'édition du profil de l'utilisateur.
     */
    public function edit(Request $request): View
    {
        $user = $request->user();
        $roles = Role::all(); // Récupère tous les rôles disponibles
        $userRoles = $user->roles->pluck('name')->toArray(); // Récupère les rôles de l'utilisateur
        $canEditRoles = $user->can('user.role.assign'); // Vérifie si l'utilisateur a la permission de modifier les rôles
        $cities = \App\Models\City::where('is_active', true)->orderBy('name')->get();// Charger la liste des villes pour le formulaire
        
        
        return view('profile.edit', [
            'user' => $user,
            'roles' => $roles,
            'userRoles' => $userRoles,
            'canEditRoles' => $canEditRoles,
            'cities' => $cities,
        ]);
    }

    /**
     * Mettre à jour les informations du profil de l'utilisateur.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        
        // Mise à jour des informations de base du profil
        $user->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        // Mise à jour des rôles si l'utilisateur a la permission nécessaire
        if ($request->has('roles') && $user->can('user.role.assign')) {
            $user->syncRoles($request->roles);
        }

        $user->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Supprimer le compte de l'utilisateur.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}