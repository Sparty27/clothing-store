import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/admin/scss/app.scss',
                'resources/admin/js/app.js',

                'resources/site/scss/app.scss',
                'resources/site/js/app.js',
            ],
            refresh: true,
        }),
    ],
    css: {
        postcss: './postcss.config.js',
        preprocessorOptions: {
            scss: {
                api: 'modern-compiler'
            }
        }
    },
});
