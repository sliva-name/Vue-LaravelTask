# backend/Dockerfile
FROM php:8.3-cli

# system deps
RUN apt-get update && DEBIAN_FRONTEND=noninteractive apt-get install -y \
    libpq-dev \
    unzip \
    git \
    curl \
    default-mysql-client \
    && docker-php-ext-install pdo pdo_pgsql \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# composer: copy from official image
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# copy composer files first for caching
COPY composer.json composer.lock ./
# install composer deps (will use mounted vendor if present)
RUN composer install --no-interaction --prefer-dist --optimize-autoloader --no-scripts || true

# copy the rest
COPY . .

# ensure vendor exists (if not mounted)
RUN if [ ! -d "vendor" ]; then composer install --no-interaction --prefer-dist --optimize-autoloader; fi

# права
RUN chown -R www-data:www-data /var/www/html \
 && chmod -R 755 /var/www/html/storage || true

EXPOSE 9000

# dev command (artisan serve). Для production — используйте php-fpm + nginx.
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=9000"]
