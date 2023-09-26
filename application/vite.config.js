import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss',
                'resources/js/app.js',
                'resources/css/mig-bootstrap.css',
                'resources/css/mig-index.css',
                'resources/js/offerphi/goods.js',
            ],
            refresh: true,
        }),
    ],
});
