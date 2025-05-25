<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\URL;

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

        // Vérifier si la locale est valide
        if (!$locale || !in_array($locale, ['en', 'fr'])) {
            $locale = Session::get('locale', 'en'); // Valeur par défaut
        }

        // Définir la locale pour cette requête
        App::setLocale($locale);
        URL::defaults(['locale' => $locale]);

        // Stocker la locale dans la session pour la conserver
        Session::put('locale', $locale);

        // Débogage
        Log::info('Locale définie à: ' . $locale . ' via URL');

        return $next($request);
    }
}