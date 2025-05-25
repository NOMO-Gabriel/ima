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
        $cities = \App\Models\City::orderBy('name')->get(['id', 'name']);
        
        // Charger les centres avec leurs villes, regroupés par ville
        $centers = \App\Models\Center::with('city')
            ->where('is_active', true)
            ->orderBy('name')
            ->get(['id', 'name', 'city_id']);

            // dd($centers);
        
        // Grouper les centres par ville pour faciliter le filtrage côté client
        $centersByCity = $centers->groupBy('city_id');
        
        return view('auth.register', [
            'cities' => $cities,
            'centers' => $centers,
            'centersByCity' => $centersByCity,
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
            'gender' => ['required', 'in:male,female'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'phone_number' => ['required', 'string', 'max:20', 'unique:'.User::class],
            'parent_phone_number' => ['nullable', 'string', 'max:20'],
            'city_id' => ['required', 'exists:cities,id'],
            'center_id' => ['nullable', 'exists:centers,id'],
            'address' => ['required', 'string', 'max:255'],
            'establishment' => ['required', 'string', 'max:255'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'terms' => ['required', 'accepted'],
        ], [
            // Messages personnalisés
            'gender.required' => 'Le genre est obligatoire.',
            'gender.in' => 'Le genre sélectionné n\'est pas valide.',
            'first_name.required' => 'Le prénom est obligatoire.',
            'last_name.required' => 'Le nom est obligatoire.',
            'email.unique' => 'Cette adresse email est déjà utilisée.',
            'phone_number.unique' => 'Ce numéro de téléphone est déjà utilisé.',
            'city_id.required' => 'La ville est obligatoire.',
            'city_id.exists' => 'La ville sélectionnée n\'existe pas.',
            'center_id.exists' => 'Le centre sélectionné n\'existe pas.',
            'address.required' => 'L\'adresse est obligatoire.',
            'establishment.required' => 'L\'établissement d\'origine est obligatoire.',
            'terms.accepted' => 'Vous devez accepter les conditions d\'utilisation.',
        ]);

        // Créer l'utilisateur élève
        $user = User::create([
            'first_name' => strtoupper($request->first_name), // Convertir en majuscules
            'last_name' => strtoupper($request->last_name),   // Convertir en majuscules
            'gender' => $request->gender,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'parent_phone_number' => $request->parent_phone_number,
            'city_id' => $request->city_id,
            'center_id' => $request->center_id,
            'address' => $request->address,
            'establishment' => $request->establishment,
            'account_type' => 'eleve', // Forcé à élève
            'password' => Hash::make($request->password),
            'status' => 'pending_validation', // En attente de validation
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