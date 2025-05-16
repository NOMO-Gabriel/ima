<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "<h1>Test des dossiers de stockage Laravel</h1>";

try {
    require '/home/u777715388/domains/darkgoldenrod-deer-926463.hostingersite.com/ima/vendor/autoload.php';
    echo "<p style='color:green;font-weight:bold;'>✓ Autoloader chargé avec succès!</p>";
    
    $storagePath = '/home/u777715388/domains/darkgoldenrod-deer-926463.hostingersite.com/ima/storage';
    $bootstrapPath = '/home/u777715388/domains/darkgoldenrod-deer-926463.hostingersite.com/ima/bootstrap/cache';
    
    echo "<h2>Vérification des dossiers importants:</h2>";
    echo "<ul>";
    
    // Vérifier si storage existe
    if (is_dir($storagePath)) {
        echo "<li>Dossier storage: <span style='color:green;font-weight:bold;'>Existe</span></li>";
        
        // Vérifier si storage est accessible en écriture
        if (is_writable($storagePath)) {
            echo "<li>Dossier storage: <span style='color:green;font-weight:bold;'>Accessible en 
écriture</span></li>";
            
            // Essayer d'écrire un fichier de test
            $testFile = $storagePath . '/test_' . time() . '.txt';
            if (file_put_contents($testFile, 'Test file ' . date('Y-m-d H:i:s'))) {
                echo "<li>Écriture dans storage: <span 
style='color:green;font-weight:bold;'>Réussie</span></li>";
                unlink($testFile); // Supprimer le fichier de test
            } else {
                echo "<li>Écriture dans storage: <span style='color:red;font-weight:bold;'>Échouée</span></li>";
            }
        } else {
            echo "<li>Dossier storage: <span style='color:red;font-weight:bold;'>NON accessible en 
écriture</span></li>";
        }
    } else {
        echo "<li>Dossier storage: <span style='color:red;font-weight:bold;'>N'existe PAS</span></li>";
    }
    
    // Vérifier bootstrap/cache
    if (is_dir($bootstrapPath)) {
        echo "<li>Dossier bootstrap/cache: <span style='color:green;font-weight:bold;'>Existe</span></li>";
        
        if (is_writable($bootstrapPath)) {
            echo "<li>Dossier bootstrap/cache: <span style='color:green;font-weight:bold;'>Accessible en 
écriture</span></li>";
            
            // Essayer d'écrire un fichier de test
            $testFile = $bootstrapPath . '/test_' . time() . '.txt';
            if (file_put_contents($testFile, 'Test file ' . date('Y-m-d H:i:s'))) {
                echo "<li>Écriture dans bootstrap/cache: <span 
style='color:green;font-weight:bold;'>Réussie</span></li>";
                unlink($testFile); // Supprimer le fichier de test
            } else {
                echo "<li>Écriture dans bootstrap/cache: <span 
style='color:red;font-weight:bold;'>Échouée</span></li>";
            }
        } else {
            echo "<li>Dossier bootstrap/cache: <span style='color:red;font-weight:bold;'>NON accessible en 
écriture</span></li>";
        }
    } else {
        echo "<li>Dossier bootstrap/cache: <span style='color:red;font-weight:bold;'>N'existe PAS</span></li>";
        
        // Tenter de créer le dossier
        echo "<li>Tentative de création du dossier bootstrap/cache...</li>";
        if (mkdir($bootstrapPath, 0755, true)) {
            echo "<li>Création du dossier bootstrap/cache: <span 
style='color:green;font-weight:bold;'>Réussie</span></li>";
        } else {
            echo "<li>Création du dossier bootstrap/cache: <span 
style='color:red;font-weight:bold;'>Échouée</span></li>";
        }
    }
    
    echo "</ul>";
} catch (Throwable $e) {
    die("<p style='color:red;font-weight:bold;'>✗ Erreur lors du chargement de l'autoloader: " . $e->getMessage() 
. "</p>");
}

echo "<p><a href='test.php'>← Retour aux tests</a></p>";
