<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        // Charger la liste des villes pour le formulaire
        $cities = \App\Models\City::where('is_active', true)->orderBy('name')->get();

        return view('auth.register', [
            'cities' => $cities
        ]);
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'phone_number' => ['required', 'string', 'max:20', 'unique:'.User::class],
            'city_id' => ['nullable', 'exists:cities,id'],
            'account_type' => ['required', 'string', 'in:eleve,enseignant,parent'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'terms' => ['required', 'accepted'],
        ]);

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'city_id' => $request->city_id,
            'account_type' => $request->account_type,
            'password' => Hash::make($request->password),
            'status' => 'pending_validation', // Par défaut, les utilisateurs sont en attente de validation
        ]);

        event(new Registered($user));

        // Assigner le rôle en fonction du type de compte sélectionné
        $user->assignRole($request->account_type);

        Auth::login($user);

        // Ajoutez un message de succès à la session
        Session::flash('status', 'Votre compte a été créé avec succès!');
        Session::flash('status-type', 'success');

        return redirect(route('dashboard', absolute: false));
    }
}
