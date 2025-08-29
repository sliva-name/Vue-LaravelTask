FROM php:8.3-fpm

# Системные зависимости
RUN apt-get update && apt-get install -y \
    libpq-dev \
    unzip \
    git \
    curl \
    && docker-php-ext-install pdo pdo_pgsql

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Рабочая директория
WORKDIR /var/www/html

# Копируем файлы проекта
COPY . .

# Устанавливаем зависимости
RUN composer install --no-dev --optimize-autoloader

# Команда запуска Laravel
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=9000"]
