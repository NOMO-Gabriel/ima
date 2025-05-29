<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Student;
use App\Models\Center;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
// Remarque: Auth n'est pas utilisé ici, donc `use Illuminate\Support\Facades\Auth;` peut être enlevé si non utilisé ailleurs.

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        // Charger la liste des centres actifs, uniquement ID et nom
        $centers = Center::where('is_active', true)
            ->orderBy('name')
            ->select('id', 'name') // MODIFIÉ ICI
            ->get();

        return view('auth.register', [
            'centers' => $centers
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
            'phone_number' => ['required', 'string', 'max:20', 'unique:'.User::class], // Numéro de l'élève
            'parent_phone_number' => ['nullable', 'string', 'max:20'], // Numéro du parent
            'center_id' => ['required', 'exists:centers,id'],
            'establishment' => ['required', 'string', 'max:255'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'terms' => ['required', 'accepted'],
        ]);

        // Récupérer le centre choisi pour obtenir sa ville
        // On doit toujours le récupérer en entier ici pour avoir la ville
        $selectedCenter = Center::find($request->center_id);
        if (!$selectedCenter) {
            return back()->withInput()->withErrors(['center_id' => 'Le centre sélectionné est invalide.']);
        }

        // Créer l'utilisateur
        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone_number' => $request->phone_number, // Numéro de l'élève
            'center_id' => $request->center_id,
            'city' => $selectedCenter->city, // Ville du centre
            'account_type' => 'student',
            'password' => Hash::make($request->password),
            'status' => User::STATUS_PENDING_VALIDATION,
        ]);

        // Créer l'entrée pour l'élève dans la table students
        Student::create([
            'user_id' => $user->id,
            'establishment' => $request->establishment,
            'parent_phone_number' => $request->parent_phone_number, // Numéro du parent stocké sur student
        ]);

        event(new Registered($user));

        // Assigner automatiquement le rôle élève
        if (method_exists($user, 'myAssignRole')) {
            $user->myAssignRole('eleve');
        } elseif (method_exists($user, 'assignRole')) {
            $user->assignRole('eleve');
        }

        Session::flash('status', 'Votre compte a été créé avec succès! Il sera activé après validation par notre équipe financière.');
        Session::flash('status-type', 'success');

        return redirect()->route('login', ['locale' => app()->getLocale()]);
    }
}
