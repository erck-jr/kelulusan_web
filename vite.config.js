import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite'; // <-- Pastikan ini di-import

export default defineConfig({
    plugins: [
        tailwindcss(), // <-- Dan pastikan ini dipanggil SEBELUM laravel()
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
});