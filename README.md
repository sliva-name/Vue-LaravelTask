

## Установка

1. Перейти в папку `backend`:
```bash
cd backend
```

2. Создайте .env
   ```bash cp .env.example .env ```

Добавить в .env :
 ```bash 
DB_CONNECTION=pgsql
DB_HOST=db
DB_PORT=5432
DB_DATABASE=articles_db
DB_USERNAME=laravel
DB_PASSWORD=secret
 ```
3. запускаем
```bash 
docker-compose up -d --build
docker-compose exec app composer install
docker-compose exec app php artisan key:generate
docker-compose exec app php artisan migrate 
```




**Фронт на http://localhost:5173/**
**Бэк http://localhost:9000/api**