# 🚀 Tekstura - Nuxt + Laravel

Простой и быстрый способ запуска проекта.

## Быстрый старт

```bash
# Запустить проект
make start

# Или полный старт с миграциями
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

## Структура проекта

```
├── frontend/          # Nuxt 3 приложение
├── backend/           # Laravel API
├── nginx/            # Nginx конфигурация
├── docker-compose.yml # Docker настройки
└── Makefile          # Команды управления
```

## Разработка

```bash
# Запуск в режиме разработки (без Docker)
make dev

# В разных терминалах:
make backend         # Laravel сервер
make frontend        # Nuxt сервер
```

## Устранение проблем

```bash
# Перезапуск с пересборкой
make restart

# Очистка и перезапуск
make clean && make start

# Проверка статуса
make status
```