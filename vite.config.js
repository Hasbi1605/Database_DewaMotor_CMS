import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                // Admin Panel
                "resources/css/app.css",
                "resources/js/app.js",
                // Store/Public
                "resources/css/store.css",
                // Auth Pages
                "resources/css/auth.css",
                // Dashboard
                "resources/css/dashboard.css",
            ],
            refresh: true,
        }),
    ],
    build: {
        // Optimasi untuk produksi
        rollupOptions: {
            output: {
                manualChunks: {
                    // Pisahkan vendor chunks untuk caching yang lebih baik
                    vendor: ["bootstrap"],
                },
                // Naming pattern untuk aset
                chunkFileNames: "assets/js/[name]-[hash].js",
                entryFileNames: "assets/js/[name]-[hash].js",
                assetFileNames: (assetInfo) => {
                    const info = assetInfo.name.split(".");
                    const ext = info[info.length - 1];
                    if (/\.(css)$/.test(assetInfo.name)) {
                        return `assets/css/[name]-[hash].${ext}`;
                    }
                    if (
                        /\.(png|jpe?g|svg|gif|tiff|bmp|ico)$/i.test(
                            assetInfo.name
                        )
                    ) {
                        return `assets/images/[name]-[hash].${ext}`;
                    }
                    return `assets/[name]-[hash].${ext}`;
                },
            },
        },
        // Minifikasi aset
        minify: "terser",
        // Kompresi
        reportCompressedSize: true,
        // Threshold untuk warning ukuran chunk
        chunkSizeWarningLimit: 1000,
        // Sourcemap untuk debugging (hanya di development)
        sourcemap: process.env.NODE_ENV === "development",
    },
    server: {
        // Hot reload untuk development
        hmr: {
            host: "localhost",
        },
        watch: {
            usePolling: true,
        },
    },
    css: {
        // Post CSS untuk autoprefixer
        postcss: {},
        devSourcemap: true,
    },
    // Optimasi dependencies
    optimizeDeps: {
        include: ["bootstrap"],
    },
});
