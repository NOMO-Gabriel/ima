<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "Testing bootstrap...<br>";

try {
    require '/home/u777715388/domains/darkgoldenrod-deer-926463.hostingersite.com/ima/vendor/autoload.php';
    echo "Autoloader loaded successfully!<br>";
    
    try {
        $app = require_once 
'/home/u777715388/domains/darkgoldenrod-deer-926463.hostingersite.com/ima/bootstrap/app.php';
        echo "Bootstrap loaded successfully!<br>";
        echo "App class: " . get_class($app) . "<br>";
    } catch (Exception $e) {
        die("Error loading bootstrap: " . $e->getMessage() . "<br>Trace: <pre>" . $e->getTraceAsString() . 
"</pre>");
    }
} catch (Exception $e) {
    die("Error loading autoloader: " . $e->getMessage());
}

echo "End of test.";

