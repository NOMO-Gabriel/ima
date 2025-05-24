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
        // Charger la liste des villes actives depuis la base de données
        $cities = \App\Models\City::where('is_active', true)
            ->orderBy('name')
            ->get();

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
            'city_id' => ['required', 'exists:cities,id'], // Obligatoire maintenant
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'terms' => ['required', 'accepted'],
        ]);

        // Créer l'utilisateur élève uniquement
        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'city_id' => $request->city_id,
            'account_type' => 'eleve', // Forcé à élève
            'password' => Hash::make($request->password),
            'status' => 'pending_validation', // En attente de validation par la responsable financière
        ]);

        event(new Registered($user));

        // Assigner automatiquement le rôle élève
        $user->myAssignRole('eleve');

        // Ne pas connecter automatiquement l'utilisateur
        // Auth::login($user);

        // Message d'information
        Session::flash('status', 'Votre compte a été créé avec succès! Il sera activé après validation par notre équipe financière.');
        Session::flash('status-type', 'success');

        // Rediriger vers la page de connexion avec la locale
        return redirect()->route('login', ['locale' => app()->getLocale()]);
    }
}