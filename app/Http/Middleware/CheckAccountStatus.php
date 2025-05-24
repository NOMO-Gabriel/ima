<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;

class CheckAccountStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();
            
            // Vérifier le statut du compte
            switch ($user->status) {
                case User::STATUS_PENDING_VALIDATION:
                    Auth::logout();
                    return redirect()->route('login', ['locale' => app()->getLocale()])
                        ->with('error', 'Votre compte est en attente de validation par notre équipe financière.');
                
                case User::STATUS_PENDING_CONTRACT:
                    Auth::logout();
                    return redirect()->route('login', ['locale' => app()->getLocale()])
                        ->with('error', 'Votre compte a été validé mais vos concours et contrat sont en cours d\'assignation.');
                
                case User::STATUS_SUSPENDED:
                    Auth::logout();
                    return redirect()->route('login', ['locale' => app()->getLocale()])
                        ->with('error', 'Votre compte a été suspendu. Veuillez contacter l\'administration.');
                
                case User::STATUS_REJECTED:
                    Auth::logout();
                    return redirect()->route('login', ['locale' => app()->getLocale()])
                        ->with('error', 'Votre demande d\'inscription a été rejetée.');
                
                case User::STATUS_ARCHIVED:
                    Auth::logout();
                    return redirect()->route('login', ['locale' => app()->getLocale()])
                        ->with('error', 'Votre compte a été archivé. Veuillez contacter l\'administration.');
                
                case User::STATUS_ACTIVE:
                    // Compte actif, continuer
                    break;
                
                default:
                    Auth::logout();
                    return redirect()->route('login', ['locale' => app()->getLocale()])
                        ->with('error', 'Statut de compte non reconnu.');
            }
        }

        return $next($request);
    }
}