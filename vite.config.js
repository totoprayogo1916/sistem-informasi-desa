import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/scss/app.scss'],
            refresh: true,
            // buildDirectory: './',
        }),
    ],
    build: {
        assetsDir: './',
        outDir: 'public/assets'
    }
});
