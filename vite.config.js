import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                // Main App Assets
                'resources/css/app.scss',
                'resources/js/app.js',
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
            '@': '/resources',
            '@css': '/resources/css',
            '@js': '/resources/js',
        }
    },
    build: {
        rollupOptions: {
            output: {
                manualChunks: {
                    // Vendor chunks
                    'vendor-bootstrap': ['bootstrap'],
                    'vendor-alpine': [
                        'alpinejs'
                    ],
                }
            }
        },
        // Increase chunk size warning limit
        chunkSizeWarningLimit: 1000,
    },
    server: {
        host: 'localhost',
        port: 3000,
        hmr: {
            host: 'localhost',
        },
    },
    optimizeDeps: {
        include: [
            'bootstrap',
            'alpinejs'
        ]
    }
});
