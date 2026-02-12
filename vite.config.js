import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
     plugins: [
        laravel({
            input: [
                'resources/css/app.css',   // keep existing CSS
                'resources/sass/app.scss', // ✅ add SASS
                'resources/js/app.js'
            ],
            refresh: true,
        }),
    ],
});
