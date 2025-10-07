export default defineNuxtConfig({
    compatibilityDate: '2025-07-15',
    devtools: { enabled: true },
    ssr: true,
    apiBase: process.env.SERVER_API_BASE || 'http://laravel_app:9000/api',
    runtimeConfig: {
        // серверная часть (SSR/Nitro) будет обращаться прямо к laravel контейнеру
        apiBase: process.env.SERVER_API_BASE || 'http://laravel_app:9000/api',

        // публичная — для клиента (браузера)
        public: {
            apiBase: process.env.API_BASE_URL_CLIENT || '/api'
        }
    },

    vite: {
        server: {
            host: true, // слушать 0.0.0.0
            hmr: {
                protocol: 'ws',
                host: process.env.VITE_HMR_HOST || 'localhost',
                port: process.env.VITE_HMR_PORT ? Number(process.env.VITE_HMR_PORT) : 5173,
            },
            watch: { usePolling: true, interval: 1000 }
        }
    }
})
