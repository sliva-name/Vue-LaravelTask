# 🚀 Tekstura Infrastructure

Инфраструктура для проекта Tekstura (Nuxt + Laravel).

## Структура

```
├── docker-compose.yml      # Основная конфигурация Docker
├── docker-compose.prod.yml # Продакшн конфигурация
├── nginx/                  # Nginx конфигурации
│   ├── default.conf        # Dev конфигурация
│   └── prod.conf          # Prod конфигурация
├── Makefile               # Команды управления
├── start.sh              # Скрипт запуска (Linux/Mac)
├── start.bat             # Скрипт запуска (Windows)
└── env.example           # Пример переменных окружения
```

## Быстрый старт

### 1. Клонирование всех репозиториев

```bash
# Создайте папку для проекта
mkdir tekstura-project
cd tekstura-project

# Клонируйте репозитории
git clone <infrastructure-repo-url> infrastructure
git clone <backend-repo-url> backend  
git clone <frontend-repo-url> frontend

# Переименуйте папки согласно docker-compose
mv backend backend
mv frontend frontend
```

### 2. Настройка окружения

```bash
cd infrastructure

# Скопируйте пример конфигурации
cp env.example .env

# Отредактируйте .env файл
nano .env
```

### 3. Запуск проекта

```bash
# Установка зависимостей и запуск
make setup
make start-full
```

## Доступ к приложению

- 🌐 **Frontend**: http://localhost:5173
- 🔧 **API**: http://localhost:5173/api  
- ⚡ **Direct Nuxt**: http://localhost:3000

## Основные команды

```bash
make help          # Показать все команды
make start         # Запустить проект
make stop          # Остановить проект
make restart       # Перезапустить
make logs          # Показать логи
make migrate       # Выполнить миграции
make seed          # Заполнить БД тестовыми данными
make clean         # Очистить кэш
```

## Переменные окружения

Создайте `.env` файл на основе `env.example`:

```env
# Database
DB_PASSWORD=your_secure_password

# Environment
APP_ENV=local
NODE_ENV=development

# Docker Images (опционально)
BACKEND_IMAGE=tekstura-backend:latest
FRONTEND_IMAGE=tekstura-frontend:latest
```

## Продакшн развертывание

```bash
# Используйте продакшн конфигурацию
docker-compose -f docker-compose.prod.yml up -d

# Или через Makefile
make prod
```

## Требования

- Docker & Docker Compose
- Make (опционально, для удобства)
- Git

## Структура репозиториев

Этот репозиторий содержит только инфраструктуру. Для полной работы проекта также нужны:

- **Backend репозиторий**: Laravel API приложение
- **Frontend репозиторий**: Nuxt.js приложение

## Поддержка

При возникновении проблем:

1. Проверьте логи: `make logs`
2. Перезапустите проект: `make restart`
3. Очистите кэш: `make clean && make start`
