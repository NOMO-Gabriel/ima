<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param  Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Obtenir la locale depuis le paramètre d'URL
        $locale = $request->route('locale');

        if (!in_array($locale, ['en', 'fr'])) {
            $locale = 'en'; // Valeur par défaut
        }

        // Définir la locale pour cette requête
        App::setLocale($locale);

        // Stocker la locale dans la session pour la conserver
        Session::put('locale', $locale);

        // Débogage
        Log::info('Locale définie à: ' . $locale . ' via URL');

        return $next($request);
    }
}
