<?php
// Définir l'en-tête pour indiquer que c'est du HTML
header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tests Laravel pour Hostinger</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        h1 {
            color: #333;
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
        }
        ul {
            list-style-type: none;
            padding: 0;
        }
        li {
            margin-bottom: 10px;
        }
        a {
            display: inline-block;
            background-color: #f5f5f5;
            padding: 10px 15px;
            text-decoration: none;
            color: #333;
            border-radius: 4px;
            border: 1px solid #ddd;
            transition: all 0.3s ease;
        }
        a:hover {
            background-color: #e0e0e0;
            transform: translateY(-2px);
        }
        .description {
            margin-top: 5px;
            font-size: 14px;
            color: #666;
        }
        .test-section {
            margin-bottom: 30px;
        }
        h2 {
            color: #555;
            margin-top: 20px;
        }
        .success {
            color: green;
            font-weight: bold;
        }
        .warning {
            color: orange;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <h1>Tests de diagnostic Laravel sur Hostinger</h1>
    <p>Cliquez sur les liens ci-dessous pour exécuter différents tests qui aideront à diagnostiquer le problème 
avec votre déploiement Laravel.</p>
    
    <div class="test-section">
        <h2>1. Tests de base PHP</h2>
        <ul>
            <li>
                <a href="phpinfo.php">Test PHP Info</a>
                <div class="description">Affiche les informations détaillées sur la configuration PHP du 
serveur.</div>
            </li>
            <li>
                <a href="hello.php">Test Hello World</a>
                <div class="description">Simple test "Hello World" pour vérifier que PHP fonctionne 
correctement.</div>
            </li>
        </ul>
    </div>
    
    <div class="test-section">
        <h2>2. Tests de composants Laravel</h2>
        <ul>
            <li>
                <a href="autoload-test.php">Test Autoloader</a>
                <div class="description">Vérifie que l'autoloader de Composer peut être chargé 
correctement.</div>
            </li>
            <li>
                <a href="bootstrap-test.php">Test Bootstrap</a>
                <div class="description">Vérifie le chargement du fichier bootstrap/app.php de Laravel.</div>
            </li>
            <li>
                <a href="kernel-test.php">Test Kernel</a>
                <div class="description">Vérifie le chargement du kernel HTTP de Laravel.</div>
            </li>
            <li>
                <a href="request-test.php">Test Request/Response</a>
                <div class="description">Teste la capture d'une requête HTTP et la génération d'une 
réponse.</div>
            </li>
        </ul>
    </div>
    
    <div class="test-section">
        <h2>3. Tests de configuration</h2>
        <ul>
            <li>
                <a href="env-test.php">Test .env</a>
                <div class="description">Vérifie que le fichier .env est correctement chargé et que les variables 
essentielles sont définies.</div>
            </li>
            <li>
                <a href="db-test.php">Test Base de données</a>
                <div class="description">Teste la connexion à la base de données configurée.</div>
            </li>
            <li>
                <a href="storage-test.php">Test Storage</a>
                <div class="description">Vérifie que les dossiers de stockage sont accessibles en écriture.</div>
            </li>
        </ul>
    </div>
    
    <div class="test-section">
        <h2>4. Actions</h2>
        <ul>
            <li>
                <a href="restore.php">Restaurer index.php d'origine</a>
                <div class="description">Restaure le fichier index.php d'origine pour l'application 
Laravel.</div>
            </li>
            <li>
                <a href="clear-cache.php">Vider les caches</a>
                <div class="description">Vide tous les caches de l'application Laravel manuellement.</div>
            </li>
        </ul>
    </div>

    <p class="warning">Note : Créez d'abord tous les fichiers de test avant de les exécuter !</p>
</body>
</html>
