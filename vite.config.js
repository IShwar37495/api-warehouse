import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import vue from "@vitejs/plugin-vue";

const isProduction = process.env.APP_ENV === "production";

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
        https: isProduction,
    },

    build: {
        minify: "terser", // Explicitly use Terser for minification
        terserOptions: {
            compress: {
                drop_console: true, // Remove console logs
                drop_debugger: true, // Remove debugger statements
            },
            mangle: true, // Shorten variable names
            format: {
                comments: false, // Remove comments
            },
        },

        // ✅ Move rollupOptions inside the build object
        rollupOptions: {
            output: {
                assetFileNames: (assetInfo) => {
                    return `assets/[name]-[hash][extname]`;
                },
                chunkFileNames: "assets/[name]-[hash].js",
                entryFileNames: "assets/[name]-[hash].js",
            },
        },
    },
});
