FROM dunglas/frankenphp:php8.2-bookworm

RUN apt-get update && apt-get install -y git curl zip unzip libicu-dev libzip-dev && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-configure intl && docker-php-ext-install -j$(nproc) intl zip pdo pdo_mysql

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

COPY composer.json composer.lock ./

RUN composer install --no-dev --optimize-autoloader --no-scripts --no-interaction

COPY . .

RUN mkdir -p storage/framework/{sessions,views,cache,testing} storage/logs bootstrap/cache && chmod -R 775 storage bootstrap/cache

# Skip npm build - assets already built locally and committed
# RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - && apt-get install -y nodejs && rm -rf /var/lib/apt/lists/*
# RUN npm ci && npm run build && npm prune --omit=dev

RUN php artisan config:cache && php artisan event:cache && php artisan route:cache && php artisan view:cache

# Copy startup script and make it executable
COPY docker-entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

EXPOSE 8080

# Use startup script that runs migrations before starting server
CMD ["/usr/local/bin/docker-entrypoint.sh"]
