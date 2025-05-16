import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
            // Spécifier le chemin correct pour le build
            buildDirectory: 'build',
            // Configurer le chemin public
            publicDirectory: 'public',
        }),
    ],
    // Assurez-vous que le manifest est généré au bon endroit
    build: {
        manifest: true,
        outDir: 'public/build',
        rollupOptions: {
            output: {
                manualChunks: {
                    // Configuration optionnelle pour séparer les chunks
                },
            },
        },
    },
});