#!/bin/bash

# Скрипт для развертывания проекта Tekstura из отдельных Git репозиториев
# Использование: ./deploy-from-repos.sh

set -e

# Цвета для вывода
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
RED='\033[0;31m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

echo -e "${GREEN}🚀 Развертывание проекта Tekstura из Git репозиториев${NC}"
echo ""

# Проверка наличия Git и Docker
if ! command -v git &> /dev/null; then
    echo -e "${RED}❌ Git не установлен. Установите Git и повторите попытку.${NC}"
    exit 1
fi

if ! command -v docker &> /dev/null; then
    echo -e "${RED}❌ Docker не установлен. Установите Docker и повторите попытку.${NC}"
    exit 1
fi

if ! command -v docker-compose &> /dev/null; then
    echo -e "${RED}❌ Docker Compose не установлен. Установите Docker Compose и повторите попытку.${NC}"
    exit 1
fi

# Функция для клонирования репозитория
clone_repo() {
    local repo_name=$1
    local repo_url=$2
    local target_dir=$3
    
    echo -e "${YELLOW}📥 Клонирование ${repo_name}...${NC}"
    
    if [ -d "$target_dir" ]; then
        echo -e "  📂 Папка ${target_dir} уже существует"
        echo -e "  🔄 Обновление репозитория..."
        cd "$target_dir"
        git pull origin main
        cd - > /dev/null
    else
        echo -e "  📥 Клонирование из ${repo_url}"
        git clone "$repo_url" "$target_dir"
    fi
    
    echo -e "  ✅ ${repo_name} готов"
    echo ""
}

# Функция для запроса URL репозитория
get_repo_url() {
    local repo_name=$1
    echo -n "Введите URL для репозитория ${repo_name}: "
    read url
    echo "$url"
}

echo -e "${YELLOW}📋 Инструкции:${NC}"
echo "1. Убедитесь, что у вас есть URL репозиториев"
echo "2. Введите URL каждого репозитория"
echo "3. Скрипт автоматически клонирует и настроит проект"
echo ""

# Запрашиваем URL репозиториев
echo -e "${YELLOW}🔗 Введите URL репозиториев:${NC}"
INFRASTRUCTURE_URL=$(get_repo_url "infrastructure")
BACKEND_URL=$(get_repo_url "backend")
FRONTEND_URL=$(get_repo_url "frontend")

# Создаем папку для проекта
PROJECT_DIR="tekstura-deployed"
echo -e "${BLUE}📁 Создание папки проекта: ${PROJECT_DIR}${NC}"
mkdir -p "$PROJECT_DIR"
cd "$PROJECT_DIR"

echo ""
echo -e "${GREEN}🔧 Клонирование репозиториев...${NC}"

# Клонируем репозитории
clone_repo "Infrastructure" "$INFRASTRUCTURE_URL" "infrastructure"
clone_repo "Backend" "$BACKEND_URL" "backend"
clone_repo "Frontend" "$FRONTEND_URL" "frontend"

echo -e "${GREEN}✅ Репозитории клонированы!${NC}"
echo ""

# Настройка окружения
echo -e "${YELLOW}⚙️  Настройка окружения...${NC}"

if [ -f "infrastructure/env.example" ]; then
    if [ ! -f "infrastructure/.env" ]; then
        echo -e "  📝 Создание .env файла из примера"
        cp infrastructure/env.example infrastructure/.env
        echo -e "  ⚠️  Отредактируйте infrastructure/.env файл перед запуском"
    else
        echo -e "  ✅ .env файл уже существует"
    fi
else
    echo -e "  ⚠️  Файл env.example не найден в infrastructure"
fi

echo ""

# Проверка Docker
echo -e "${YELLOW}🐳 Проверка Docker...${NC}"
if docker ps > /dev/null 2>&1; then
    echo -e "  ✅ Docker работает"
else
    echo -e "  ❌ Docker не запущен. Запустите Docker и повторите попытку."
    exit 1
fi

echo ""

# Предложение запуска
echo -e "${GREEN}🎉 Проект готов к запуску!${NC}"
echo ""
echo -e "${YELLOW}📝 Следующие шаги:${NC}"
echo "1. Отредактируйте infrastructure/.env файл (если нужно)"
echo "2. Запустите проект:"
echo "   cd infrastructure"
echo "   make start-full"
echo ""
echo -e "${BLUE}🌐 После запуска приложение будет доступно:${NC}"
echo "   - Frontend: http://localhost:5173"
echo "   - API: http://localhost:5173/api"
echo "   - Direct Nuxt: http://localhost:3000"
echo ""

# Предложение автоматического запуска
echo -n "Хотите запустить проект сейчас? (y/N): "
read -r response
if [[ "$response" =~ ^[Yy]$ ]]; then
    echo ""
    echo -e "${GREEN}🚀 Запуск проекта...${NC}"
    cd infrastructure
    
    # Проверяем наличие Make
    if command -v make &> /dev/null; then
        make start-full
    else
        echo -e "${YELLOW}⚠️  Make не установлен, используем docker-compose напрямую${NC}"
        docker-compose up -d
        echo -e "${YELLOW}⏳ Ожидание запуска сервисов...${NC}"
        sleep 10
        docker-compose exec app php artisan migrate --force
        docker-compose exec app php artisan db:seed --force
    fi
    
    echo ""
    echo -e "${GREEN}✅ Проект запущен!${NC}"
    echo -e "${BLUE}🌐 Приложение доступно по адресам:${NC}"
    echo "   - Frontend: http://localhost:5173"
    echo "   - API: http://localhost:5173/api"
    echo "   - Direct Nuxt: http://localhost:3000"
fi

echo ""
echo -e "${GREEN}🎉 Развертывание завершено!${NC}"
