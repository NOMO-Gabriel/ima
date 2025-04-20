<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Afficher le formulaire d'édition du profil de l'utilisateur.
     */
    public function edit(Request $request): View
    {
        // Charger la liste des villes pour le formulaire
        $cities = \App\Models\City::where('is_active', true)->orderBy('name')->get();
        
        return view('profile.edit', [
            'user' => $request->user(),
            'cities' => $cities,
        ]);
    }

    /**
     * Mettre à jour les informations du profil de l'utilisateur.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

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