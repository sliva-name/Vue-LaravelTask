@echo off
echo ========================================
echo    Articles API - Quick Start
echo ========================================
echo.

echo [1/4] Checking Docker...
docker --version >nul 2>&1
if %errorlevel% neq 0 (
    echo ERROR: Docker not found! Please install Docker Desktop
    pause
    exit /b 1
)

echo [2/4] Building containers...
docker-compose build

echo [3/4] Starting services...
docker-compose up -d

echo [4/4] Setting up database...
timeout /t 5 >nul
docker-compose exec -T backend php artisan migrate --force
docker-compose exec -T backend php artisan db:seed --force

echo.
echo ========================================
echo    Project started successfully!
echo ========================================
echo Frontend: http://localhost:3000
echo Backend:  http://localhost:8000/api
echo.
echo To stop: docker-compose down
echo To view logs: docker-compose logs -f
echo.
pause

