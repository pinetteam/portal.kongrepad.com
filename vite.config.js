import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.scss',
                'resources/js/app.js'
            ],
            refresh: true,
        }),
    ],
    css: {
        preprocessorOptions: {
            scss: {
                additionalData: `@import "bootstrap/scss/functions"; @import "bootstrap/scss/variables";`
            }
        }
    },
    resolve: {
        alias: {
            '~bootstrap': 'bootstrap',
        }
    },
    server: {
        host: 'localhost',
        port: 3000,
        hmr: {
            host: 'localhost',
        },
    },
});
