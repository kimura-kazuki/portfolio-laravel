import { defineConfig, loadEnv } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import i18n from 'laravel-vue-i18n/vite';

const env = loadEnv(process.env.NODE_ENV, process.cwd());
const isTesting = env.VITE_APP_ENV === 'testing';

export default defineConfig({
    plugins: [
        laravel({
            input: 'resources/js/app.ts',
            ssr: 'resources/js/ssr.ts',
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
        i18n(),
    ],
    // ...(isTesting ? {
    //     server: {
    //         hmr: {
    //             host: 'host.docker.internal'
    //         },
    //         // host: '0.0.0.0',
    //     },
    // } : {}),
    server: {
        hmr: {
            host: 'host.docker.internal',
        },
        // host: '0.0.0.0',
    },
});
