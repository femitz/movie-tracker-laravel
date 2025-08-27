import vue from '@vitejs/plugin-vue';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';
import { defineConfig } from 'vite';

const isNgrok = process.env.VITE_APP_URL?.includes('ngrok');

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.ts'], // caminhos corretos
            ssr: 'resources/js/ssr.ts',
            refresh: true,
        }),
        tailwindcss(),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],
    base: '',       // caminhos relativos, evita mixed content
    server: {
        host: true,
        port: 5173,
        strictPort: true,
        hmr: isNgrok
        ? {
            protocol: 'wss',
            host: process.env.VITE_APP_URL?.replace(/^https?:\/\//, ''),
            clientPort: 443,
          }
        : true, // dev local
    },
});
