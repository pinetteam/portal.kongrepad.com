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
                // Suppress Sass deprecation warnings for Bootstrap compatibility
                silenceDeprecations: ['import', 'global-builtin', 'color-functions'],
                // Modern Sass API options
                api: 'modern-compiler',
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
