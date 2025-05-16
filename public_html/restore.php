<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
echo "<h1>Restauration du fichier index.php d'origine</h1>";
// Vérifier si le fichier de sauvegarde existe
$backupFile = '/home/u777715388/domains/darkgoldenrod-deer-926463.hostingersite.com/public_html/index.php.bak';
$targetFile = '/home/u777715388/domains/darkgoldenrod-deer-926463.hostingersite.com/public_html/index.php';
if (file_exists($backupFile)) {
    if (copy($backupFile, $targetFile)) {
        echo "<p style='color:green;font-weight:bold;'>✓ Le fichier index.php a été restauré avec succès!</p>";
    } else {
        echo "<p style='color:red;font-weight:bold;'>✗ Impossible de restaurer le fichier index.php.</p>";
    }
} else {
    echo "<p style='color:red;font-weight:bold;'>✗ Le fichier de sauvegarde index.php.bak n'existe pas.</p>";
    
    // Créer un fichier index.php par défaut correctement formaté pour Laravel 12
    $defaultContent = <<<'PHP'
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
$request = Illuminate\Http\Request::capture();
$response = $kernel->handle($request);

// Envoyer la réponse
$response->send();

// Terminer la requête
$kernel->terminate($request, $response);
PHP;
    if (file_put_contents($targetFile, $defaultContent)) {
        echo "<p style='color:green;font-weight:bold;'>✓ Un nouveau fichier index.php a été créé avec 
succès!</p>";
    } else {
        echo "<p style='color:red;font-weight:bold;'>✗ Impossible de créer un nouveau fichier index.php.</p>";
    }
}
echo "<p><a href='test.php'>← Retour aux tests</a></p>";