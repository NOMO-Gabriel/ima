php

<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "<h1>Test du fichier .env Laravel</h1>";

try {
    require '/home/u777715388/domains/darkgoldenrod-deer-926463.hostingersite.com/ima/vendor/autoload.php';
    echo "<p style='color:green;font-weight:bold;'>✓ Autoloader chargé avec succès!</p>";
    
    // Chargement explicite du fichier .env
    $envFile = '/home/u777715388/domains/darkgoldenrod-deer-926463.hostingersite.com/ima/.env';
    echo "<p>Tentative de lecture directe du fichier .env: " . (file_exists($envFile) ? "Fichier trouvé" : "Fichier non trouvé") . "</p>";
    
    if (file_exists($envFile)) {
        echo "<p>Contenu du fichier .env (10 premières lignes):</p>";
        echo "<pre>";
        $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $count = 0;
        foreach ($lines as $line) {
            if (strpos($line, '#') !== 0 && strpos($line, '=') !== false) {
                list($key, $value) = explode('=', $line, 2);
                if (strtoupper($key) === 'APP_KEY') {
                    echo "APP_KEY=******** (masqué pour sécurité)\n";
                } else {
                    echo htmlspecialchars($line) . "\n";
                }
                $count++;
                if ($count >= 10) break;
            }
        }
        echo "</pre>";
    }
    
    try {
        $app = require_once '/home/u777715388/domains/darkgoldenrod-deer-926463.hostingersite.com/ima/bootstrap/app.php';
        echo "<p style='color:green;font-weight:bold;'>✓ Bootstrap chargé avec succès!</p>";
        
        // Forcer le chargement de l'environnement
        $app->loadEnvironmentFrom('.env');
        
        echo "<h2>Vérification de APP_KEY dans le fichier .env:</h2>";
        $hasAppKey = false;
        if (file_exists($envFile)) {
            $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            foreach ($lines as $line) {
                if (strpos($line, 'APP_KEY=') === 0) {
                    $appKey = substr($line, 8);
                    $hasAppKey = !empty($appKey);
                    echo "<p>Valeur trouvée dans le fichier: " . ($hasAppKey ? substr($appKey, 0, 10) . '...' : 'Vide') . "</p>";
                    break;
                }
            }
        }
        
        // Essayer d'accéder à la configuration directement
        echo "<h2>Vérification via la configuration:</h2>";
        try {
            $key = $app['config']['app.key'];
            echo "<p>app.key via config: " . (!empty($key) ? substr($key, 0, 10) . '...' : 'Non définie') . "</p>";
        } catch (Exception $e) {
            echo "<p>Erreur lors de l'accès à config['app.key']: " . $e->getMessage() . "</p>";
        }
        
        echo "<h2>Variables d'environnement principales (via env()):</h2>";
        echo "<ul>";
        echo "<li>APP_ENV: " . env('APP_ENV', 'Non définie') . "</li>";
        echo "<li>APP_DEBUG: " . (env('APP_DEBUG', false) ? 'true' : 'false') . "</li>";
        echo "<li>APP_KEY: " . (env('APP_KEY') ? substr(env('APP_KEY'), 0, 10) . '...' : 'Non définie') . "</li>";
        echo "<li>APP_URL: " . env('APP_URL', 'Non définie') . "</li>";
        echo "<li>DB_CONNECTION: " . env('DB_CONNECTION', 'Non définie') . "</li>";
        echo "</ul>";
        
        if (!$hasAppKey) {
            echo "<p style='color:red;font-weight:bold;'>⚠️ APP_KEY n'est pas définie dans le fichier .env! Vous devez générer une clé.</p>";
        } else if (empty(env('APP_KEY'))) {
            echo "<p style='color:orange;font-weight:bold;'>⚠️ APP_KEY est définie dans le fichier .env mais n'est pas accessible via env().</p>";
        } else {
            echo "<p style='color:green;font-weight:bold;'>✓ APP_KEY est définie et accessible!</p>";
        }
        
    } catch (Throwable $e) {
        die("<p style='color:red;font-weight:bold;'>✗ Erreur lors du chargement du bootstrap: " . $e->getMessage() . "</p><pre>" . $e->getTraceAsString() . "</pre>");
    }
} catch (Throwable $e) {
    die("<p style='color:red;font-weight:bold;'>✗ Erreur lors du chargement de l'autoloader: " . $e->getMessage() . "</p>");
}

echo "<p><a href='test.php'>← Retour aux tests</a></p>";