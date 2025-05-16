<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "<h1>Nettoyage des caches Laravel</h1>";

try {
    require '/home/u777715388/domains/darkgoldenrod-deer-926463.hostingersite.com/ima/vendor/autoload.php';
    echo "<p style='color:green;font-weight:bold;'>✓ Autoloader chargé avec succès!</p>";
    
    echo "<h2>Suppression manuelle des fichiers de cache...</h2>";
    $result = [];
    
    // Chemins à vider
    $paths = [
        '/home/u777715388/domains/darkgoldenrod-deer-926463.hostingersite.com/ima/bootstrap/cache/*.php',
        
'/home/u777715388/domains/darkgoldenrod-deer-926463.hostingersite.com/ima/storage/framework/cache/data/*',
        '/home/u777715388/domains/darkgoldenrod-deer-926463.hostingersite.com/ima/storage/framework/views/*.php',
        '/home/u777715388/domains/darkgoldenrod-deer-926463.hostingersite.com/ima/storage/framework/sessions/*',
    ];
    
    foreach ($paths as $pattern) {
        $files = glob($pattern);
        if ($files) {
            foreach ($files as $file) {
                if (is_file($file)) {
                    if (unlink($file)) {
                        $result[] = "✓ Supprimé: " . basename($file);
                    } else {
                        $result[] = "✗ Impossible de supprimer: " . basename($file);
                    }
                }
            }
        } else {
            $result[] = "- Aucun fichier trouvé pour: " . $pattern;
        }
    }
    
    echo "<ul>";
    foreach ($result as $line) {
        echo "<li>" . $line . "</li>";
    }
    echo "</ul>";
    
    echo "<p style='color:green;font-weight:bold;'>Nettoyage des caches terminé!</p>";
} catch (Throwable $e) {
    die("<p style='color:red;font-weight:bold;'>✗ Erreur: " . $e->getMessage() . "</p>");
}

echo "<p><a href='test.php'>← Retour aux tests</a></p>";
