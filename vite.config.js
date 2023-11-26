import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/partials/navigation.css',
                'resources/css/partials/footer.css',
                'resources/css/partials/randomBooks.css',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
});
