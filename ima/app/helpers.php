<?php

if (!function_exists('vite_asset')) {
    function vite_asset($path)
    {
        // Si nous sommes en local et non en test, utiliser la directive @vite
        if (app()->environment('local') && !app()->runningUnitTests()) {
            return $path;
        }
        
        // Pour la production, on utilise le manifest
        $manifestPath = public_path('build/manifest.json');
        
        if (file_exists($manifestPath)) {
            $manifest = json_decode(file_get_contents($manifestPath), true);
            
            // La clé dans le manifest est souvent 'resources/css/app.css' ou 'resources/js/app.js'
            $key = 'resources/' . $path;
            
            if (isset($manifest[$key])) {
                // Le manifest contient le chemin vers le fichier hashé
                return asset('build/' . $manifest[$key]['file']);
            }
        }
        
        // Fallback si le fichier n'est pas trouvé dans le manifest
        return asset('build/assets/' . basename($path));
    }
}