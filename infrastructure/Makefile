# Makefile для проекта Vue + Laravel
.PHONY: help install start stop build test clean logs

# Цвета для вывода
GREEN := \033[32m
YELLOW := \033[33m
RED := \033[31m
RESET := \033[0m

# По умолчанию показать помощь
help:
	@echo "$(GREEN)Доступные команды:$(RESET)"
	@echo "  $(YELLOW)env$(RESET)         - Настроить файлы окружения (.env)"
	@echo "  $(YELLOW)install$(RESET)     - Установить зависимости (Docker)"
	@echo "  $(YELLOW)start$(RESET)       - Запустить проект (Docker)"
	@echo "  $(YELLOW)stop$(RESET)        - Остановить проект"
	@echo "  $(YELLOW)build$(RESET)       - Собрать Docker контейнеры"
	@echo "  $(YELLOW)backend$(RESET)     - Запустить только backend (Docker)"
	@echo "  $(YELLOW)frontend$(RESET)    - Запустить только frontend (Docker)"
	@echo "  $(YELLOW)migrate$(RESET)     - Выполнить миграции (Docker)"
	@echo "  $(YELLOW)seed$(RESET)        - Заполнить БД тестовыми данными (Docker)"
	@echo "  $(YELLOW)test$(RESET)        - Запустить тесты (Docker)"
	@echo "  $(YELLOW)test-backend$(RESET) - Запустить только backend тесты (Docker)"
	@echo "  $(YELLOW)logs$(RESET)        - Показать логи"
	@echo "  $(YELLOW)clean$(RESET)       - Очистить кэш (Docker)"
	@echo "  $(YELLOW)shell$(RESET)       - Войти в контейнер backend"
	@echo "  $(YELLOW)dev$(RESET)         - Режим разработки (требует PHP/Node.js)"
	@echo "  $(YELLOW)dev-backend$(RESET) - Backend для разработки (требует PHP)"
	@echo "  $(YELLOW)dev-frontend$(RESET) - Frontend для разработки (требует Node.js)"

# Установка зависимостей (через Docker)
install:
	@echo "$(GREEN)Установка зависимостей через Docker...$(RESET)"
	@echo "$(YELLOW)Сборка образов...$(RESET)"
	$(MAKE) build
	@echo "$(GREEN)Зависимости установлены!$(RESET)"

# Запуск всего проекта через Docker
start:
	@echo "$(GREEN)Запуск проекта...$(RESET)"
	docker-compose up -d
	@echo "$(GREEN)Проект запущен!$(RESET)"
	@echo "$(YELLOW)Frontend: http://localhost:5173$(RESET)"
	@echo "$(YELLOW)Backend API: http://localhost:5173/api$(RESET)"
	@echo "$(YELLOW)Direct Nuxt: http://localhost:3000$(RESET)"

# Остановка проекта
stop:
	@echo "$(RED)Остановка проекта...$(RESET)"
	docker-compose down
	@echo "$(GREEN)Проект остановлен!$(RESET)"

# Сборка контейнеров
build:
	@echo "$(GREEN)Сборка Docker контейнеров...$(RESET)"
	@echo "$(YELLOW)Сборка frontend...$(RESET)"
	cd ../frontend && docker build -t tekstura-frontend:latest .
	@echo "$(YELLOW)Сборка backend...$(RESET)"
	cd ../backend && docker build -t tekstura-backend:latest .
	@echo "$(GREEN)Контейнеры собраны!$(RESET)"

# Запуск только backend (через Docker)
backend:
	@echo "$(GREEN)Запуск backend сервера через Docker...$(RESET)"
	docker-compose up -d app db
	@echo "$(YELLOW)Backend доступен по адресу: http://localhost:9000$(RESET)"

# Запуск только frontend (через Docker)
frontend:
	@echo "$(GREEN)Запуск frontend сервера через Docker...$(RESET)"
	docker-compose up -d frontend
	@echo "$(YELLOW)Frontend доступен по адресу: http://localhost:3000$(RESET)"

# Выполнение миграций
migrate:
	@echo "$(GREEN)Выполнение миграций...$(RESET)"
	docker-compose exec app php artisan migrate
	@echo "$(GREEN)Миграции выполнены!$(RESET)"

# Заполнение БД тестовыми данными
seed:
	@echo "$(GREEN)Заполнение БД тестовыми данными...$(RESET)"
	docker-compose exec app php artisan db:seed
	@echo "$(GREEN)БД заполнена!$(RESET)"

# Сброс и пересоздание БД
fresh:
	@echo "$(YELLOW)Сброс и пересоздание БД...$(RESET)"
	docker-compose exec app php artisan migrate:fresh --seed
	@echo "$(GREEN)БД пересоздана!$(RESET)"

# Запуск всех тестов (через Docker)
test:
	@echo "$(GREEN)Запуск тестов через Docker...$(RESET)"
	@echo "$(YELLOW)Backend тесты...$(RESET)"
	docker-compose exec app php artisan test
	@echo "$(YELLOW)Frontend тесты...$(RESET)"
	docker-compose exec frontend npm run test 2>/dev/null || echo "Frontend тесты не настроены"
	@echo "$(GREEN)Тесты завершены!$(RESET)"

# Запуск только backend тестов (через Docker)
test-backend:
	@echo "$(GREEN)Запуск backend тестов через Docker...$(RESET)"
	docker-compose exec app php artisan test

# Просмотр логов
logs:
	@echo "$(GREEN)Логи проекта:$(RESET)"
	docker-compose logs -f

# Очистка кэша и временных файлов (через Docker)
clean:
	@echo "$(GREEN)Очистка кэша через Docker...$(RESET)"
	@echo "$(YELLOW)Backend кэш...$(RESET)"
	docker-compose exec app php artisan cache:clear
	docker-compose exec app php artisan config:clear
	docker-compose exec app php artisan route:clear
	docker-compose exec app php artisan view:clear
	@echo "$(YELLOW)Frontend кэш...$(RESET)"
	docker-compose exec frontend rm -rf node_modules/.cache 2>/dev/null || true
	docker-compose exec frontend rm -rf dist 2>/dev/null || true
	@echo "$(GREEN)Кэш очищен!$(RESET)"

# Вход в контейнер backend
shell:
	@echo "$(GREEN)Вход в backend контейнер...$(RESET)"
	docker-compose exec app bash

# Настройка окружения
env:
	@echo "$(GREEN)Настройка файлов окружения...$(RESET)"
	@echo "$(YELLOW)Создание .env файлов...$(RESET)"
	@if [ ! -f .env ]; then \
		echo "$(YELLOW)Создание infrastructure/.env...$(RESET)"; \
		cp env.example .env; \
	fi
	@if [ ! -f ../backend/.env ]; then \
		echo "$(YELLOW)Создание backend/.env...$(RESET)"; \
		cp ../backend/.env.example ../backend/.env; \
	fi
	@if [ ! -f ../frontend/.env ]; then \
		echo "$(YELLOW)Создание frontend/.env...$(RESET)"; \
		cp ../frontend/.env.example ../frontend/.env 2>/dev/null || true; \
	fi
	@echo "$(GREEN)Файлы окружения настроены!$(RESET)"


# Установка и запуск (полная настройка)
setup: env install
	@echo "$(GREEN)Настройка проекта...$(RESET)"
	@echo "$(YELLOW)Запуск контейнеров для настройки...$(RESET)"
	docker-compose up -d app db
	@sleep 10
	@echo "$(YELLOW)Генерация ключа приложения...$(RESET)"
	docker-compose exec app php artisan key:generate 2>/dev/null || true
	@echo "$(GREEN)Проект настроен! Используйте 'make start' для запуска$(RESET)"

# Проверка статуса
status:
	@echo "$(GREEN)Статус сервисов:$(RESET)"
	@docker-compose ps 2>/dev/null || echo "Docker не запущен"
	@echo "$(YELLOW)Проверка портов:$(RESET)"
	@netstat -an | findstr ":3000 " 2>/dev/null || echo "Frontend (3000): не запущен"
	@netstat -an | findstr ":8000 " 2>/dev/null || echo "Backend (8000): не запущен"

# Быстрый перезапуск
restart: stop start

# Полный старт с миграциями
start-full: start
	@echo "$(YELLOW)Выполнение миграций...$(RESET)"
	@sleep 10
	docker-compose exec app php artisan migrate --force
	docker-compose exec app php artisan db:seed --force
	@echo "$(GREEN)Проект полностью готов!$(RESET)"

# Разработческий режим (без Docker) - требует PHP и Node.js
dev:
	@echo "$(GREEN)Запуск в режиме разработки (без Docker)...$(RESET)"
	@echo "$(YELLOW)ВНИМАНИЕ: Требует установленные PHP и Node.js!$(RESET)"
	@echo "$(YELLOW)Запускайте в разных терминалах:$(RESET)"
	@echo "  make dev-backend"
	@echo "  make dev-frontend"

# Запуск backend для разработки (требует PHP)
dev-backend:
	@echo "$(GREEN)Запуск backend для разработки...$(RESET)"
	@echo "$(YELLOW)Требует установленный PHP!$(RESET)"
	cd ../backend && php artisan serve --host=0.0.0.0 --port=8000

# Запуск frontend для разработки (требует Node.js)
dev-frontend:
	@echo "$(GREEN)Запуск frontend для разработки...$(RESET)"
	@echo "$(YELLOW)Требует установленный Node.js!$(RESET)"
	cd ../frontend && npm run dev

