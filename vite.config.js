// vite.config.js
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import dotenv from 'dotenv';


dotenv.config(); // dotenv konfigürasyonunu burada yapın


export default defineConfig({
    plugins: [
        laravel([
            'resources/js/app.js',
        ]),
    ],
});