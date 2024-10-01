import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/mine.css', // main custom CSS
                'resources/js/app.js',
                'resources/js/dashboard.js',
                'resources/js/operation.js'
            ],
            refresh: true,
        }),
    ],
});
