import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';


export default defineConfig({
    server: {
        port: 8080, // Imposta la porta su cui vuoi che Vite serva il tuo progetto
    },
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
});
