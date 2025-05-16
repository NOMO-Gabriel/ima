<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
echo "<h1>Test de connexion à la base de données</h1>";
try {
    require '/home/u777715388/domains/darkgoldenrod-deer-926463.hostingersite.com/ima/vendor/autoload.php';
    echo "<p style='color:green;font-weight:bold;'>✓ Autoloader chargé avec succès!</p>";
    
    try {
        $app = require_once '/home/u777715388/domains/darkgoldenrod-deer-926463.hostingersite.com/ima/bootstrap/app.php';
        echo "<p style='color:green;font-weight:bold;'>✓ Bootstrap chargé avec succès!</p>";
        
        // Ces étapes supplémentaires sont nécessaires pour initialiser correctement l'application
        $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
        $kernel->bootstrap();
        
        // Maintenant l'application est complètement chargée
        echo "<p style='color:green;font-weight:bold;'>✓ Application Laravel complètement initialisée!</p>";
        
        // Maintenant env() fonctionnera correctement
        $dbConnection = env('DB_CONNECTION', 'Non définie');
        echo "<p>Type de connexion: " . $dbConnection . "</p>";
        
        if ($dbConnection == 'sqlite') {
            $dbPath = env('DB_DATABASE', 'Non définie');
            echo "<p>Chemin de la base de données SQLite: " . $dbPath . "</p>";
            
            if (file_exists($dbPath)) {
                echo "<p style='color:green;font-weight:bold;'>✓ Le fichier SQLite existe!</p>";
                
                try {
                    // Test avec PDO
                    $pdo = new PDO("sqlite:" . $dbPath);
                    echo "<p style='color:green;font-weight:bold;'>✓ Connexion directe à SQLite réussie!</p>";
                    
                    // Test avec Laravel DB en utilisant les méthodes Laravel 12
                    try {
                        $db = app('db');
                        
                        // Exécuter une requête pour obtenir la liste des tables
                        $query = "SELECT name FROM sqlite_master WHERE type='table' AND name NOT LIKE 'sqlite_%'";
                        $tables = $db->connection()->select($query);
                        
                        $tableNames = array_map(function($table) {
                            return $table->name;
                        }, $tables);
                        
                        echo "<p style='color:green;font-weight:bold;'>✓ Connexion avec Laravel DB réussie!</p>";
                        echo "<p>Tables dans la base de données: " . implode(", ", $tableNames) . "</p>";
                    } catch (Exception $e) {
                        echo "<p style='color:red;font-weight:bold;'>✗ Erreur de connexion avec Laravel DB: " . $e->getMessage() . "</p>";
                    }
                } catch (PDOException $e) {
                    echo "<p style='color:red;font-weight:bold;'>✗ Erreur de connexion à SQLite: " . $e->getMessage() . "</p>";
                }
            } else {
                echo "<p style='color:red;font-weight:bold;'>✗ Le fichier SQLite n'existe pas à: " . $dbPath . "</p>";
            }
        } else {
            echo "<p>Hôte: " . env('DB_HOST', 'Non défini') . "</p>";
            echo "<p>Base de données: " . env('DB_DATABASE', 'Non définie') . "</p>";
            echo "<p>Utilisateur: " . env('DB_USERNAME', 'Non défini') . "</p>";
            
            try {
                $db = app('db');
                $db->connection()->getPdo();
                echo "<p style='color:green;font-weight:bold;'>✓ Connexion à la base de données réussie!</p>";
            } catch (Exception $e) {
                echo "<p style='color:red;font-weight:bold;'>✗ Erreur de connexion à la base de données: " . $e->getMessage() . "</p>";
            }
        }
    } catch (Throwable $e) {
        die("<p style='color:red;font-weight:bold;'>✗ Erreur lors du chargement du bootstrap: " . $e->getMessage() . "</p><pre>" . $e->getTraceAsString() . "</pre>");
    }
} catch (Throwable $e) {
    die("<p style='color:red;font-weight:bold;'>✗ Erreur lors du chargement de l'autoloader: " . $e->getMessage() . "</p>");
}
echo "<p><a href='test.php'>← Retour aux tests</a></p>";