import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    optimizeDeps: {
        include: ['@eonasdan/tempus-dominus', 'moment'],
    },
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss',
                'resources/css/meeting-pages-theme.css',
                
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
});
