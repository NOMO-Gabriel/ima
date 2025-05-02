<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

define('LARAVEL_START', microtime(true));

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require __DIR__.'/../vendor/autoload.php';

// Bootstrap Laravel and handle the request...
/** @var Application $app */
$app = require_once __DIR__.'/../bootstrap/app.php';

// Capture the request
$request = Request::capture();

// Nous devons démarrer les services avant d'utiliser des fonctionnalités comme app()->setLocale()
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->bootstrap();

// Get the URI path from the request
$uri = $request->getPathInfo();
$segments = explode('/', trim($uri, '/'));

// Define supported locales
$locales = ['fr', 'en']; // Ajoutez vos locales supportées ici

// Check if the first segment is a valid locale
$isValidLocale = !empty($segments[0]) && in_array($segments[0], $locales);

// If no valid locale in URL, determine preferred locale
if (!$isValidLocale) {
    $preferredLocale = $request->getPreferredLanguage($locales) ?? $locales[0];

    // For API routes, don't redirect but set default locale
    if ($request->expectsJson() || $request->is('api/*')) {
        app()->setLocale($preferredLocale);
    } else {
        // For web routes, redirect to include the locale in the URL
        $redirectPath = '/' . $preferredLocale;
        if ($uri !== '/') {
            $redirectPath .= $uri;
        }

        header('Location: ' . $redirectPath, true, 302);
        exit;
    }
} else {
    // Set application locale based on URL segment
    app()->setLocale($segments[0]);
}

// Handle security for HTTPS requests
if ($request->isSecure()) {
    URL::forceScheme('https');
}

// Process the request properly using the kernel
$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);
