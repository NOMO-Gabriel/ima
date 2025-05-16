<?php

/**
 * Laravel - A PHP Framework For Web Artisans
 */

// Affichage des erreurs pour le débogage (à commenter en production)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

define('LARAVEL_START', microtime(true));

// Chemins absolus vers votre installation Laravel dans le dossier ima
require '/home/u777715388/domains/darkgoldenrod-deer-926463.hostingersite.com/ima/vendor/autoload.php';

$app = require_once '/home/u777715388/domains/darkgoldenrod-deer-926463.hostingersite.com/ima/bootstrap/app.php';

// Obtenir le kernel HTTP
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

// Traiter la requête
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
)->send();

// Terminer la requête
$kernel->terminate($request, $response);

