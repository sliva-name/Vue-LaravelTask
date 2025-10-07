export default defineNuxtPlugin((nuxtApp) => {
    const cfg = useRuntimeConfig()
    const serverBase = (cfg.apiBase || 'http://laravel_app:9000/api').replace(/\/$/, '')
    const clientBase = (cfg.public?.apiBase || '/api').replace(/\/$/, '')

    // универсальная функция которая выбирает базу в зависимости от окружения
    const buildUrl = (path: string) => {
        const base = process.server ? serverBase : clientBase
        return `${base}${path.startsWith('/') ? path : '/' + path}`
    }

    const api = {
        async fetch(path: string, opts: any = {}) {
            const url = buildUrl(path)
            // на сервере лучше использовать $fetch (nuxt/nitro/undici), в клиенте тоже подойдет $fetch
            return $fetch(url, opts)
        },
        get(path: string, opts: any = {}) {
            return api.fetch(path, { method: 'GET', ...opts })
        },
        post(path: string, body?: any, opts: any = {}) {
            return api.fetch(path, { method: 'POST', body, ...opts })
        },
        // при необходимости добавь put/delete и т.д.
    }

    // регистрируем под $api
    nuxtApp.provide('api', api)
})