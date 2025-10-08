# 🌐 Tekstura Frontend (Nuxt.js)

Frontend приложение для проекта Tekstura на Nuxt 4.

## Особенности

- Nuxt 4 с Vue 3
- Server-Side Rendering (SSR)
- TypeScript поддержка
- Адаптивный дизайн
- Docker контейнеризация

## Быстрый старт

### 1. Установка зависимостей

```bash
npm install
```

### 2. Настройка окружения

```bash
cp .env.example .env
```

### 3. Запуск в режиме разработки

```bash
npm run dev
```

Приложение будет доступно по адресу: http://localhost:3000

## Docker

### Сборка образа

```bash
docker build -t tekstura-frontend:latest .
```

### Запуск в Docker

```bash
docker run -p 3000:3000 \
  -e API_BASE_URL=http://laravel_app:9000/api \
  tekstura-frontend:latest
```

## Структура проекта

```
app/
├── components/          # Vue компоненты
├── layouts/            # Макеты страниц
├── pages/              # Страницы (автоматическая маршрутизация)
├── plugins/            # Nuxt плагины
└── app.vue            # Главный компонент

public/                # Статические файлы
nuxt.config.ts        # Конфигурация Nuxt
```

## Конфигурация

### Переменные окружения

```env
# API URL для серверной части (SSR)
SERVER_API_BASE=http://laravel_app:9000/api

# API URL для клиентской части
API_BASE_URL_CLIENT=/api

# HMR настройки (для разработки)
VITE_HMR_HOST=localhost
VITE_HMR_PORT=5173
```

### Nuxt конфигурация

Основные настройки в `nuxt.config.ts`:

- SSR включен для SEO
- API проксирование через nginx
- HMR для разработки
- TypeScript поддержка

## Разработка

### Добавление новых страниц

Создайте файл в папке `pages/`:

```vue
<!-- pages/articles/index.vue -->
<template>
  <div>
    <h1>Статьи</h1>
    <!-- Ваш контент -->
  </div>
</template>

<script setup>
// Логика страницы
</script>
```

### Создание компонентов

```vue
<!-- components/ArticleCard.vue -->
<template>
  <div class="article-card">
    <h3>{{ article.title }}</h3>
    <p>{{ article.excerpt }}</p>
  </div>
</template>

<script setup>
interface Props {
  article: {
    title: string
    excerpt: string
  }
}

defineProps<Props>()
</script>
```

### API интеграция

```typescript
// composables/useArticles.ts
export const useArticles = () => {
  const { $fetch } = useNuxtApp()
  
  const getArticles = async () => {
    return await $fetch('/api/articles')
  }
  
  return {
    getArticles
  }
}
```

## Сборка для продакшна

```bash
# Генерация статических файлов
npm run generate

# Сборка для SSR
npm run build
```

## Тестирование

```bash
# Запуск тестов (если настроены)
npm run test

# Линтинг
npm run lint
```

## Развертывание

### С Docker

```bash
# Сборка образа
docker build -t tekstura-frontend:latest .

# Запуск
docker run -p 3000:3000 tekstura-frontend:latest
```

### Статический хостинг

```bash
# Генерация статических файлов
npm run generate

# Файлы будут в папке .output/public/
```

## Требования

- Node.js 18+
- npm или yarn
- Docker (опционально)

## Поддержка

При возникновении проблем:

1. Очистите кэш: `rm -rf .nuxt .output`
2. Переустановите зависимости: `rm -rf node_modules && npm install`
3. Проверьте переменные окружения

## Лицензия

MIT