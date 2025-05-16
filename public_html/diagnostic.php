<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "1. Vérification de l'environnement<br>";
echo "PHP version: " . phpversion() . "<br>";

$autoloadPath = 
'/home/u777715388/domains/darkgoldenrod-deer-926463.hostingersite.com/ima/vendor/autoload.php';
echo "2. Vérification de l'autoloader: ";
if (file_exists($autoloadPath)) {
    echo "OK<br>";
    require $autoloadPath;
} else {
    die("ERREUR - Fichier non trouvé<br>");
}

$bootstrapPath = 
'/home/u777715388/domains/darkgoldenrod-deer-926463.hostingersite.com/ima/bootstrap/app.php';
echo "3. Vérification du bootstrap: ";
if (file_exists($bootstrapPath)) {
    echo "OK<br>";
    try {
        $app = require_once $bootstrapPath;
        echo "4. Application chargée avec succès<br>";
    } catch (Exception $e) {
        die("ERREUR lors du chargement de l'application: " . $e->getMessage() . 
"<br>");
    }
} else {
    die("ERREUR - Fichier bootstrap non trouvé<br>");
}

echo "5. Vérification de la configuration Laravel<br>";
try {
    $laravelVersion = app()::VERSION;
    echo "Version de Laravel: " . $laravelVersion . "<br>";
    
    echo "Environnement: " . app()->environment() . "<br>";
    
    echo "Base de données configurée: " . config('database.default') . "<br>";
    
    echo "6. Tout fonctionne jusqu'ici<br>";
} catch (Exception $e) {
    echo "ERREUR lors de la vérification de la configuration: " . $e->getMessage() . 
"<br>";
}

echo "7. Test du chargement du kernel<br>";
try {
    $kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
    echo "Kernel chargé avec succès<br>";
} catch (Exception $e) {
    echo "ERREUR lors du chargement du kernel: " . $e->getMessage() . "<br>";
}

echo "8. Test de la requête<br>";
try {
    $request = Illuminate\Http\Request::capture();
    echo "Requête créée avec succès<br>";
} catch (Exception $e) {
    echo "ERREUR lors de la création de la requête: " . $e->getMessage() . "<br>";
}

echo "9. Test de la réponse<br>";
try {
    $response = $kernel->handle($request);
    echo "Réponse générée avec succès<br>";
} catch (Exception $e) {
    echo "ERREUR lors de la génération de la réponse: " . $e->getMessage() . "<br>";
    echo "Trace: <pre>" . $e->getTraceAsString() . "</pre>";
}

echo "<hr>Diagnostic terminé.";
