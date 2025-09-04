
# Articles API - FullStack приложение

Простое приложение для управления статьями и комментариями на Laravel + Vue 3.

## Технологии

- **Backend**: Laravel 12 + PostgreSQL
- **Frontend**: Vue 3 + Composition API
- **Контейнеризация**: Docker

## Быстрый запуск

### С помощью Makefile (рекомендуется)

```bash
# Установка зависимостей
make install

# Полная настройка проекта
make setup

# Запуск проекта
make start
```

### Ручная установка

1. **Клонировать репозиторий**
```bash
git clone <repo-url>
cd Vue-LaravelTask
```

2. **Backend настройка**
```bash
cd backend
composer install
cp .env.example .env
php artisan key:generate
```

5. **Запуск через Docker**
```bash
docker-compose up -d --build
docker-compose exec backend php artisan migrate
docker-compose exec backend php artisan db:seed
```

## Доступ к приложению

- **Frontend**: http://localhost:3000
- **Backend API**: http://localhost:8000/api

## Makefile команды

```bash
make help          # Показать все команды
make install       # Установить зависимости
make setup         # Полная настройка проекта
make start         # Запустить проект
make stop          # Остановить проект
make restart       # Перезапустить проект
make migrate       # Выполнить миграции
make seed          # Заполнить БД тестовыми данными
make fresh         # Пересоздать БД
make test          # Запустить тесты
make logs          # Показать логи
make clean         # Очистить кэш
make shell         # Войти в backend контейнер
make dev           # Режим разработки (без Docker)
```

## API Endpoints

### Статьи
- `GET /api/articles` - Список статей
- `GET /api/articles/{id}` - Получить статью с комментариями  
- `POST /api/articles` - Создать статью
- `PUT /api/articles/{id}` - Обновить статью
- `DELETE /api/articles/{id}` - Удалить статью

### Комментарии
- `POST /api/articles/{id}/comments` - Добавить комментарий
- `DELETE /api/comments/{id}` - Удалить комментарий