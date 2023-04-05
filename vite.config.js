import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import path from 'path'

export default defineConfig({
    plugins: [
        laravel({
            input: [
				'resources/css/app.css',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
    resolve: {
        alias: {
          '~bootstrap': path.resolve(__dirname, 'node_modules/bootstrap'),
		  '~@fortawesome': path.resolve(__dirname, 'node_modules/@fortawesome'),
		  '~datatables.net-bs5': path.resolve(__dirname, 'node_modules/datatables.net-bs5'),
		  '~@tarekraafat': path.resolve(__dirname, 'node_modules/@tarekraafat'),
		  '~google-charts': path.resolve(__dirname, 'node_modules/google-charts'),
		  '~tinymce': path.resolve(__dirname, 'node_modules/tinymce'),
        }
    },
});