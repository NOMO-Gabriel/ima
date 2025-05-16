<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
echo "<h1>Rafraîchissement de l'application Laravel</h1>";

// Chemin vers l'application Laravel
$basePath = '/home/u777715388/domains/darkgoldenrod-deer-926463.hostingersite.com/ima';
$publicPath = '/home/u777715388/domains/darkgoldenrod-deer-926463.hostingersite.com/public_html';

echo "<h2>1. Vider les caches</h2>";

// Fonction pour exécuter les commandes Artisan via shell_exec
function runArtisan($command) {
    global $basePath;
    $fullCommand = "cd $basePath && php artisan $command 2>&1";
    $output = shell_exec($fullCommand);
    echo "<pre>$output</pre>";
    return $output;
}

// Vider les caches manuellement
function clearCaches() {
    global $basePath;
    
    // Dossiers à vider
    $cacheFolders = [
        "$basePath/bootstrap/cache/*.php",
        "$basePath/storage/framework/cache/data/*",
        "$basePath/storage/framework/views/*.php",
        "$basePath/storage/framework/sessions/*",
    ];
    
    foreach ($cacheFolders as $folder) {
        $command = "rm -f $folder";
        shell_exec($command);
        echo "Vidé: $folder<br>";
    }
    
    // Recréer le fichier .gitignore dans les dossiers vidés
    $gitignoreContent = "*\n!.gitignore\n";
    file_put_contents("$basePath/storage/framework/cache/data/.gitignore", $gitignoreContent);
    file_put_contents("$basePath/storage/framework/views/.gitignore", $gitignoreContent);
    file_put_contents("$basePath/storage/framework/sessions/.gitignore", $gitignoreContent);
    
    echo "<p style='color:green;font-weight:bold;'>✓ Caches vidés manuellement avec succès!</p>";
}

// Essayer d'abord avec Artisan
echo "<p>Tentative d'utilisation d'Artisan...</p>";

try {
    runArtisan("config:clear");
    runArtisan("cache:clear");
    runArtisan("view:clear");
    runArtisan("route:clear");
    echo "<p style='color:green;font-weight:bold;'>✓ Caches vidés avec Artisan avec succès!</p>";
} catch (Exception $e) {
    echo "<p style='color:orange;font-weight:bold;'>⚠ Échec de l'utilisation d'Artisan: " . $e->getMessage() . "</p>";
    echo "<p>Tentative de vidage manuel des caches...</p>";
    clearCaches();
}

echo "<h2>2. Réinitialisation des permissions</h2>";

function resetPermissions() {
    global $basePath;
    
    // Définir les permissions pour les dossiers de stockage
    $commands = [
        "chmod -R 755 $basePath/storage",
        "chmod -R 755 $basePath/bootstrap/cache",
        "find $basePath/storage -type d -exec chmod 755 {} \;",
        "find $basePath/storage -type f -exec chmod 644 {} \;",
    ];
    
    foreach ($commands as $command) {
        shell_exec($command);
        echo "Exécuté: $command<br>";
    }
    
    echo "<p style='color:green;font-weight:bold;'>✓ Permissions réinitialisées avec succès!</p>";
}

resetPermissions();

echo "<h2>3. Vérification de la base de données</h2>";

// Vérifier et corriger les permissions de la base de données SQLite
$dbPath = "$basePath/database/database.sqlite";
if (file_exists($dbPath)) {
    chmod($dbPath, 0664);
    echo "<p>Base de données SQLite trouvée. Permissions mises à jour (0664).</p>";
    echo "<p>Chemin: $dbPath</p>";
    echo "<p>Taille: " . filesize($dbPath) . " octets</p>";
} else {
    echo "<p style='color:red;font-weight:bold;'>⚠ Base de données SQLite non trouvée à l'emplacement: $dbPath</p>";
}

echo "<h2>4. Modification du fichier index.php</h2>";

// Créer un nouveau fichier index.php optimisé
$indexContent = <<<'PHP'
<?php
/**
 * Laravel - A PHP Framework For Web Artisans
 */

define('LARAVEL_START', microtime(true));

// Définir explicitement le répertoire de base de l'application
$basePath = '/home/u777715388/domains/darkgoldenrod-deer-926463.hostingersite.com/ima';

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

// Obtenir le kernel HTTP
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

// Traiter la requête
$request = Illuminate\Http\Request::capture();
$response = $kernel->handle($request);

// Envoyer la réponse
$response->send();

// Terminer le traitement
$kernel->terminate($request, $response);
PHP;

file_put_contents("$publicPath/index.php", $indexContent);
echo "<p style='color:green;font-weight:bold;'>✓ Fichier index.php mis à jour avec succès!</p>";

echo "<h2>5. Vérification du fichier .htaccess</h2>";

// Créer ou mettre à jour le fichier .htaccess
$htaccessContent = <<<'HTACCESS'
<IfModule mod_rewrite.c>
    <IfModule mod_negotiation.c>
        Options -MultiViews -Indexes
    </IfModule>

    RewriteEngine On

    # Handle Authorization Header
    RewriteCond %{HTTP:Authorization} .
    RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]

    # Redirect Trailing Slashes If Not A Folder...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_URI} (.+)/$
    RewriteRule ^ %1 [L,R=301]

    # Send Requests To Front Controller...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
</IfModule>
HTACCESS;

file_put_contents("$publicPath/.htaccess", $htaccessContent);
echo "<p style='color:green;font-weight:bold;'>✓ Fichier .htaccess mis à jour avec succès!</p>";

echo "<h2>6. Redémarrage de PHP et Apache</h2>";
echo "<p>Note: Sur un hébergement partagé, nous ne pouvons pas redémarrer ces services directement.</p>";
echo "<p>L'application a été rafraîchie au maximum de ce qui est possible sur un hébergement partagé.</p>";

// Créer un fichier phpinfo pour vérifier la configuration
$phpinfoContent = "<?php phpinfo(); ?>";
file_put_contents("$publicPath/phpinfo_check.php", $phpinfoContent);
echo "<p>Un fichier <a href='phpinfo_check.php'>phpinfo_check.php</a> a été créé pour vérifier la configuration PHP.</p>";

echo "<h2>Actions terminées</h2>";
echo "<p>Le rafraîchissement de l'application est terminé. Veuillez vérifier si l'application fonctionne maintenant.</p>";
echo "<p><a href='/' style='background-color:#4CAF50;color:white;padding:10px 15px;text-decoration:none;border-radius:4px;'>Aller à l'application</a></p>";
echo "<p><a href='laravel-test.php' style='background-color:#2196F3;color:white;padding:10px 15px;text-decoration:none;border-radius:4px;'>Exécuter les tests</a></p>";