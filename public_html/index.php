<?php
/**
 * Laravel - A PHP Framework For Web Artisans
*/
define('LARAVEL_START', microtime(true));

// Définir explicitement le répertoire de base de l'application
// $basePath = '/home/u777715388/domains/darkgoldenrod-deer-926463.hostingersite.com/ima';
$basePath = '../ima';
$publicPath = $basePath . '/public';

// Créer un lien symbolique du dossier build si nécessaire
// Ceci est ajouté pour faciliter l'accès aux assets Vite
if (!file_exists(__DIR__ . '/build') && file_exists($publicPath . '/build')) {
    @symlink($publicPath . '/build', __DIR__ . '/build');
}

// Vérifier si la requête concerne un asset (fichier statique)
$uri = $_SERVER['REQUEST_URI'];
if (strpos($uri, '/build/') === 0) {
    // Rediriger vers le fichier dans ima/public
    $assetPath = $publicPath . $uri;
    if (file_exists($assetPath)) {
        // Définir le type MIME approprié
        $extension = pathinfo($assetPath, PATHINFO_EXTENSION);
        switch ($extension) {
            case 'css':
                header('Content-Type: text/css');
                break;
            case 'js':
                header('Content-Type: application/javascript');
                break;
            case 'svg':
                header('Content-Type: image/svg+xml');
                break;
            case 'png':
                header('Content-Type: image/png');
                break;
            case 'jpg':
            case 'jpeg':
                header('Content-Type: image/jpeg');
                break;
            case 'gif':
                header('Content-Type: image/gif');
                break;
            case 'woff':
                header('Content-Type: font/woff');
                break;
            case 'woff2':
                header('Content-Type: font/woff2');
                break;
            case 'ttf':
                header('Content-Type: font/ttf');
                break;
            case 'eot':
                header('Content-Type: application/vnd.ms-fontobject');
                break;
            case 'json':
                header('Content-Type: application/json');
                break;
        }
        
        // Ajout du cache pour améliorer les performances
        $maxAge = 31536000; // 1 an
        header('Cache-Control: public, max-age=' . $maxAge);
        header('Expires: ' . gmdate('D, d M Y H:i:s', time() + $maxAge) . ' GMT');
        
        readfile($assetPath);
        exit;
    }
}

// Afficher les erreurs en développement (commenter en production)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Charger l'autoloader de Composer
require $basePath.'/vendor/autoload.php';

// Charger l'application Laravel
$app = require_once $basePath.'/bootstrap/app.php';

// Définir explicitement les chemins
$app->useStoragePath($basePath.'/storage');
$app->useDatabasePath($basePath.'/database');
$app->useBootstrapPath($basePath.'/bootstrap');
// Ne pas utiliser usePublicPath() pour garder les assets dans ima/public

// Obtenir le kernel HTTP
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

// Traiter la requête
$request = Illuminate\Http\Request::capture();
$response = $kernel->handle($request);

// Envoyer la réponse
$response->send();

// Terminer le traitement
$kernel->terminate($request, $response);