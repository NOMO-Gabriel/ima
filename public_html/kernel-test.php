<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "<h1>Test du Kernel Laravel</h1>";

try {
    require '/home/u777715388/domains/darkgoldenrod-deer-926463.hostingersite.com/ima/vendor/autoload.php';
    echo "<p style='color:green;font-weight:bold;'>✓ Autoloader chargé avec succès!</p>";
    
    try {
        $app = require_once 
'/home/u777715388/domains/darkgoldenrod-deer-926463.hostingersite.com/ima/bootstrap/app.php';
        echo "<p style='color:green;font-weight:bold;'>✓ Bootstrap chargé avec succès!</p>";
        
        try {
            $kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
            echo "<p style='color:green;font-weight:bold;'>✓ Kernel chargé avec succès!</p>";
        } catch (Throwable $e) {
            die("<p style='color:red;font-weight:bold;'>✗ Erreur lors du chargement du kernel: " . 
$e->getMessage() . "</p><pre>" . $e->getTraceAsString() . "</pre>");
        }
    } catch (Throwable $e) {
        die("<p style='color:red;font-weight:bold;'>✗ Erreur lors du chargement du bootstrap: " . 
$e->getMessage() . "</p><pre>" . $e->getTraceAsString() . "</pre>");
    }
} catch (Throwable $e) {
    die("<p style='color:red;font-weight:bold;'>✗ Erreur lors du chargement de l'autoloader: " . $e->getMessage() 
. "</p>");
}

echo "<p><a href='test.php'>← Retour aux tests</a></p>";
