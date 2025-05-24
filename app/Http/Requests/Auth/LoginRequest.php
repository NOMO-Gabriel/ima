<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use App\Models\User;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        // Vérifier si l'utilisateur existe
        $user = User::where('email', $this->input('email'))->first();

        if (!$user) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'email' => trans('auth.failed'),
            ]);
        }

        // Vérifier le statut du compte avant l'authentification
        $this->checkAccountStatus($user);

        if (! Auth::attempt($this->only('email', 'password'), $this->boolean('remember'))) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'email' => trans('auth.failed'),
            ]);
        }

        RateLimiter::clear($this->throttleKey());
    }

    /**
     * Vérifie le statut du compte utilisateur
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function checkAccountStatus(User $user): void
    {
        switch ($user->status) {
            case User::STATUS_PENDING_VALIDATION:
                throw ValidationException::withMessages([
                    'email' => 'Votre compte est en attente de validation par notre équipe financière. Vous recevrez un email une fois votre compte validé.',
                ]);

            case User::STATUS_PENDING_CONTRACT:
                throw ValidationException::withMessages([
                    'email' => 'Votre compte a été validé mais vos concours et contrat sont en cours d\'assignation. Vous recevrez un email une fois le processus terminé.',
                ]);

            case User::STATUS_SUSPENDED:
                throw ValidationException::withMessages([
                    'email' => 'Votre compte a été suspendu. Veuillez contacter l\'administration pour plus d\'informations.',
                ]);

            case User::STATUS_REJECTED:
                throw ValidationException::withMessages([
                    'email' => 'Votre demande d\'inscription a été rejetée. Motif: ' . ($user->rejection_reason ?? 'Non spécifié'),
                ]);

            case User::STATUS_ARCHIVED:
                throw ValidationException::withMessages([
                    'email' => 'Votre compte a été archivé. Veuillez contacter l\'administration pour le réactiver.',
                ]);

            case User::STATUS_ACTIVE:
                // Compte actif, connexion autorisée
                break;

            default:
                throw ValidationException::withMessages([
                    'email' => 'Statut de compte non reconnu. Veuillez contacter l\'administration.',
                ]);
        }
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     */
    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->string('email')).'|'.$this->ip());
    }
}