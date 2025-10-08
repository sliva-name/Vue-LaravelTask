# 🔧 Tekstura Backend (Laravel API)

Backend API для проекта Tekstura на Laravel 12.

## Особенности

- Laravel 12 с Sanctum аутентификацией
- PostgreSQL база данных
- API для статей и комментариев
- Docker контейнеризация
- Полное покрытие тестами

## Структура API

### Статьи
- `GET /api/articles` - Список статей
- `POST /api/articles` - Создание статьи
- `GET /api/articles/{id}` - Получение статьи
- `PUT /api/articles/{id}` - Обновление статьи
- `DELETE /api/articles/{id}` - Удаление статьи

### Комментарии
- `GET /api/articles/{id}/comments` - Комментарии к статье
- `POST /api/articles/{id}/comments` - Создание комментария
- `PUT /api/comments/{id}` - Обновление комментария
- `DELETE /api/comments/{id}` - Удаление комментария

## Быстрый старт

### 1. Установка зависимостей

```bash
composer install
```

### 2. Настройка окружения

```bash
cp .env.example .env
php artisan key:generate
```

### 3. Настройка базы данных

```bash
# В .env файле укажите настройки БД
DB_CONNECTION=pgsql
DB_HOST=postgres_db
DB_PORT=5432
DB_DATABASE=articles_db
DB_USERNAME=laravel
DB_PASSWORD=secret
```

### 4. Миграции и сиды

```bash
php artisan migrate
php artisan db:seed
```

### 5. Запуск сервера

```bash
php artisan serve
```

## Docker

### Сборка образа

```bash
docker build -t tekstura-backend:latest .
```

### Запуск в Docker

```bash
docker run -p 9000:9000 \
  -e DB_HOST=postgres_db \
  -e DB_PASSWORD=secret \
  tekstura-backend:latest
```

## Тестирование

```bash
# Запуск всех тестов
php artisan test

# Запуск конкретного теста
php artisan test --filter=ArticleApiTest

# С покрытием кода
php artisan test --coverage
```

## Разработка

### Структура проекта

```
app/
├── Http/
│   ├── Controllers/     # API контроллеры
│   ├── Requests/        # Валидация запросов
│   └── Resources/       # API ресурсы
├── Models/              # Eloquent модели
└── Services/            # Бизнес-логика

database/
├── migrations/          # Миграции БД
├── seeders/            # Сиды для тестовых данных
└── factories/          # Фабрики для тестов

tests/
├── Feature/            # Интеграционные тесты
└── Unit/               # Юнит тесты
```

### Добавление новой функциональности

1. Создайте миграцию: `php artisan make:migration create_new_table`
2. Создайте модель: `php artisan make:model NewModel`
3. Создайте контроллер: `php artisan make:controller Api/NewController`
4. Добавьте роуты в `routes/api.php`
5. Напишите тесты

## API Документация

### Аутентификация

API использует Laravel Sanctum для аутентификации:

```bash
# Получение токена
POST /api/login
{
  "email": "user@example.com",
  "password": "password"
}

# Использование токена
Authorization: Bearer {token}
```

### Примеры запросов

```bash
# Получение всех статей
curl -H "Accept: application/json" \
     http://localhost:9000/api/articles

# Создание статьи
curl -X POST \
     -H "Content-Type: application/json" \
     -H "Authorization: Bearer {token}" \
     -d '{"title":"Новая статья","content":"Содержимое"}' \
     http://localhost:9000/api/articles
```

## Требования

- PHP 8.2+
- Composer
- PostgreSQL 15+
- Docker (опционально)

## Лицензия

MIT