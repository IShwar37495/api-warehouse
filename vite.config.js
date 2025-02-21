import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import vue from "@vitejs/plugin-vue";

export default defineConfig({
    plugins: [
        laravel({
            input: "resources/js/app.js",
            ssr: "resources/js/ssr.js",
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
    ],
    server: {
        https: true,
        host: "0.0.0.0",
        port: 3000,
    },
    build: {
        rollupOptions: {
            output: {
                assetFileNames: (assetInfo) => {
                    return `assets/[name]-[hash][extname]`;
                },
                chunkFileNames: "assets/[name]-[hash].js",
                entryFileNames: "assets/[name]-[hash].js",
            },
        },
        base: "https://api-warehouse-production-6639.up.railway.app/",
    },
});
