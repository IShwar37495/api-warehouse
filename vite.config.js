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
    // Add this server configuration
    server: {
        https: true,
        host: "0.0.0.0", // Ensure the server is accessible externally
        port: 3000, // You can specify a port if needed
    },
    // Force assets to use HTTPS
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
        // Ensure the base URL is set to your production URL
        base: "https://api-warehouse-production-6639.up.railway.app/",
    },
});
