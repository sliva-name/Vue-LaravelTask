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
	@echo "  $(YELLOW)install$(RESET)     - Установить зависимости для backend и frontend"
	@echo "  $(YELLOW)start$(RESET)       - Запустить проект (Docker)"
	@echo "  $(YELLOW)stop$(RESET)        - Остановить проект"
	@echo "  $(YELLOW)build$(RESET)       - Собрать Docker контейнеры"
	@echo "  $(YELLOW)backend$(RESET)     - Запустить только backend"
	@echo "  $(YELLOW)frontend$(RESET)    - Запустить только frontend"
	@echo "  $(YELLOW)migrate$(RESET)     - Выполнить миграции"
	@echo "  $(YELLOW)seed$(RESET)        - Заполнить БД тестовыми данными"
	@echo "  $(YELLOW)test$(RESET)        - Запустить тесты"
	@echo "  $(YELLOW)test-backend$(RESET) - Запустить только backend тесты"
	@echo "  $(YELLOW)logs$(RESET)        - Показать логи"
	@echo "  $(YELLOW)clean$(RESET)       - Очистить кэш и временные файлы"
	@echo "  $(YELLOW)shell$(RESET)       - Войти в контейнер backend"

# Установка зависимостей
install:
	@echo "$(GREEN)Установка зависимостей...$(RESET)"
	@echo "$(YELLOW)Backend (Composer)...$(RESET)"
	cd backend && composer install
	@echo "$(YELLOW)Frontend (NPM)...$(RESET)"
	cd frontend && npm install
	@echo "$(GREEN)Зависимости установлены!$(RESET)"

# Запуск всего проекта через Docker
start:
	@echo "$(GREEN)Запуск проекта...$(RESET)"
	docker-compose up -d
	@echo "$(GREEN)Проект запущен!$(RESET)"
	@echo "$(YELLOW)Frontend: http://localhost:3000$(RESET)"
	@echo "$(YELLOW)Backend API: http://localhost:8000/api$(RESET)"

# Остановка проекта
stop:
	@echo "$(RED)Остановка проекта...$(RESET)"
	docker-compose down
	@echo "$(GREEN)Проект остановлен!$(RESET)"

# Сборка контейнеров
build:
	@echo "$(GREEN)Сборка Docker контейнеров...$(RESET)"
	docker-compose build
	@echo "$(GREEN)Контейнеры собраны!$(RESET)"

# Запуск только backend (для разработки)
backend:
	@echo "$(GREEN)Запуск backend сервера...$(RESET)"
	cd backend && php artisan serve --host=0.0.0.0 --port=8000

# Запуск только frontend (для разработки)
frontend:
	@echo "$(GREEN)Запуск frontend сервера...$(RESET)"
	cd frontend && npm run dev

# Выполнение миграций
migrate:
	@echo "$(GREEN)Выполнение миграций...$(RESET)"
	cd backend && php artisan migrate
	@echo "$(GREEN)Миграции выполнены!$(RESET)"

# Заполнение БД тестовыми данными
seed:
	@echo "$(GREEN)Заполнение БД тестовыми данными...$(RESET)"
	cd backend && php artisan db:seed
	@echo "$(GREEN)БД заполнена!$(RESET)"

# Сброс и пересоздание БД
fresh:
	@echo "$(YELLOW)Сброс и пересоздание БД...$(RESET)"
	cd backend && php artisan migrate:fresh --seed
	@echo "$(GREEN)БД пересоздана!$(RESET)"

# Запуск всех тестов
test:
	@echo "$(GREEN)Запуск тестов...$(RESET)"
	@echo "$(YELLOW)Backend тесты...$(RESET)"
	cd backend && php artisan test
	@echo "$(YELLOW)Frontend тесты...$(RESET)"
	cd frontend && npm run test 2>/dev/null || echo "Frontend тесты не настроены"
	@echo "$(GREEN)Тесты завершены!$(RESET)"

# Запуск только backend тестов
test-backend:
	@echo "$(GREEN)Запуск backend тестов...$(RESET)"
	cd backend && php artisan test

# Просмотр логов
logs:
	@echo "$(GREEN)Логи проекта:$(RESET)"
	docker-compose logs -f

# Очистка кэша и временных файлов
clean:
	@echo "$(GREEN)Очистка кэша...$(RESET)"
	@echo "$(YELLOW)Backend кэш...$(RESET)"
	cd backend && php artisan cache:clear
	cd backend && php artisan config:clear
	cd backend && php artisan route:clear
	cd backend && php artisan view:clear
	@echo "$(YELLOW)Frontend кэш...$(RESET)"
	cd frontend && rm -rf node_modules/.cache 2>/dev/null || true
	cd frontend && rm -rf dist 2>/dev/null || true
	@echo "$(GREEN)Кэш очищен!$(RESET)"

# Вход в контейнер backend
shell:
	@echo "$(GREEN)Вход в backend контейнер...$(RESET)"
	docker-compose exec backend bash

# Установка и запуск (полная настройка)
setup: install
	@echo "$(GREEN)Настройка проекта...$(RESET)"
	@if [ ! -f backend/.env ]; then \
		echo "$(YELLOW)Создание .env файла...$(RESET)"; \
		cp backend/.env.example backend/.env 2>/dev/null || true; \
	fi
	@echo "$(YELLOW)Генерация ключа приложения...$(RESET)"
	cd backend && php artisan key:generate 2>/dev/null || true
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

# Разработческий режим (без Docker)
dev:
	@echo "$(GREEN)Запуск в режиме разработки...$(RESET)"
	@echo "$(YELLOW)Запускайте в разных терминалах:$(RESET)"
	@echo "  make backend"
	@echo "  make frontend"

