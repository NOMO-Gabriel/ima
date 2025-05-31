<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
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
        $currentCity=\App\Models\City::find($user->city_id);

        // dd($user->city_id);
        return view('profile.edit', [
            'user' => $user,
            'roles' => $roles,
            'userRoles' => $userRoles,
            'canEditRoles' => $canEditRoles,
            'cities' => $cities,
            'currentCity'=>$currentCity,
        ]);
    }

    /**
     * Mettre à jour les informations du profil de l'utilisateur.
     */
    public function update($locale, ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();

        // Mise à jour des informations de base du profil
        $user->fill($request->validated());

        if ($request->hasFile('photo')) {
            // Supprimer l'ancienne photo si elle existe
            if ($user->profile_photo_path) {
                Storage::delete('public/' . $user->profile_photo_path);
            }

            // Télécharger la nouvelle photo et stocker son chemin
            $path = $request->file('photo')->store('profile_photos', 'public');
            $user->profile_photo_path = $path;
        }

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        // Mise à jour des rôles si l'utilisateur a la permission nécessaire
        if ($request->has('roles') && $request->user()->can('user.role.assign')) {
            $user->syncRoles($request->roles);
        }

        $user->save();

        log_history('updated', $user, ['before' => $user->toArray(), 'after' => $user->toArray()]);

        return Redirect::route('profile.edit', ['locale' => app()->getLocale()] )->with('status', 'profile-updated');
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

        log_history('deleted', $user, ['before' => $user->toArray(), 'after' => []]);

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
