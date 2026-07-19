FROM dunglas/frankenphp:1-php8.4-bookworm

# Set working directory
WORKDIR /app

# Install system dependencies
RUN apt-get update && apt-get install -y --no-install-recommends \
    git \
    unzip \
    zip \
    && rm -rf /var/lib/apt/lists/*

# Install PHP extensions required by Laravel
RUN install-php-extensions \
    pcntl \
    pdo_mysql \
    zip \
    opcache \
    gd \
    intl

# Install Node.js (for compiling Tailwind CSS assets)
RUN curl -fsSL https://deb.nodesource.com/setup_22.x | bash - \
    && apt-get install -y --no-install-recommends nodejs \
    && rm -rf /var/lib/apt/lists/*

# Copy Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copy application code
COPY . /app

# Install PHP dependencies
ENV COMPOSER_ALLOW_SUPERUSER=1
RUN composer install --optimize-autoloader --no-dev --no-interaction --no-scripts

# Install Node dependencies and compile assets
RUN npm ci && npm run build && rm -rf node_modules

# Set permissions for Laravel
RUN chown -R www-data:www-data /app/storage /app/bootstrap/cache

# Run optimization scripts (except config cache which might depend on runtime environment variables)
RUN php artisan route:cache \
    && php artisan view:cache

# Set start command (run migrations and start FrankenPHP)
CMD php artisan migrate --force && frankenphp php-server --listen :$PORT --public-dir public/
