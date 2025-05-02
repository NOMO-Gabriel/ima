<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\Http\JsonResponse;

class AuthController extends ApiController
{
    /**
     * Connexion utilisateur et création de token
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function login(Request $request): JsonResponse
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'device_name' => 'nullable|string',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return $this->sendError('Identifiants incorrects', ['email' => ['Les identifiants fournis sont incorrects.']], 401);
        }

        // Mettre à jour la date de dernière connexion
        $user->last_login_at = now();
        $user->save();

        $deviceName = $request->device_name ?? $request->userAgent() ?? 'appareil inconnu';
        $token = $user->createToken($deviceName)->plainTextToken;

        return $this->sendResponse([
            'user' => $user,
            'permissions' => $user->getAllPermissions()->pluck('name'),
            'roles' => $user->roles->pluck('name'),
            'token' => $token,
        ], 'Connexion réussie');
    }

    /**
     * Inscription d'un nouvel utilisateur
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function register(Request $request): JsonResponse
    {
        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'phone_number' => ['required', 'string', 'max:20'],
            'city_id' => ['nullable', 'exists:cities,id'],
            'address' => ['nullable', 'string', 'max:255'],
        ]);

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone_number' => $request->phone_number,
            'city_id' => $request->city_id,
            'address' => $request->address,
            'status' => 'pending', // Par défaut, l'utilisateur est en attente de validation
        ]);

        // Si un rôle est spécifié et que l'utilisateur a la permission de l'attribuer
        if ($request->has('role') && $request->user() && $request->user()->can('assign roles')) {
            $user->myAssignRole($request->role);
        } else {
            // Attribuer un rôle par défaut (à adapter selon votre logique métier)
            $user->myAssignRole('user');
        }

        $deviceName = $request->device_name ?? $request->userAgent() ?? 'appareil inconnu';
        $token = $user->createToken($deviceName)->plainTextToken;

        return $this->sendResponse([
            'user' => $user,
            'token' => $token,
        ], 'Inscription réussie', 201);
    }

    /**
     * Déconnexion (Révocation du token)
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return $this->sendResponse([], 'Déconnexion réussie');
    }

    /**
     * Envoi d'un lien de réinitialisation de mot de passe
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function forgotPassword(Request $request): JsonResponse
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? $this->sendResponse([], __($status))
            : $this->sendError(__($status));
    }

    /**
     * Réinitialisation du mot de passe
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function resetPassword(Request $request): JsonResponse
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? $this->sendResponse([], __($status))
            : $this->sendError(__($status));
    }
}
