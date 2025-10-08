#!/bin/bash

echo "========================================"
echo "   Articles API - Quick Start"
echo "========================================"
echo

# Проверка Docker
if ! command -v docker &> /dev/null; then
    echo "ERROR: Docker not found! Please install Docker"
    exit 1
fi

if ! command -v docker-compose &> /dev/null; then
    echo "ERROR: Docker Compose not found! Please install Docker Compose"
    exit 1
fi

echo "[1/4] Building containers..."
docker-compose build

echo "[2/4] Starting services..."
docker-compose up -d

echo "[3/4] Waiting for services to start..."
sleep 10

echo "[4/4] Setting up database..."
docker-compose exec -T backend php artisan migrate --force
docker-compose exec -T backend php artisan db:seed --force

echo
echo "========================================"
echo "   Project started successfully!"
echo "========================================"
echo "Frontend: http://localhost:3000"
echo "Backend:  http://localhost:8000/api"
echo
echo "To stop: docker-compose down"
echo "To view logs: docker-compose logs -f"
echo

