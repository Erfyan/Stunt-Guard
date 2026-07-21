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

# Copy Composer binary
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copy full application code (required before composer install
# so post-autoload-dump scripts can find app/Helper/helper.php)
COPY . /app

# Install PHP dependencies — uses composer.lock for reproducible installs.
# post-install-cmd in composer.json will also patch voku/portable-ascii.
ENV COMPOSER_ALLOW_SUPERUSER=1
RUN composer install --optimize-autoloader --no-dev --no-interaction

# Install Node dependencies (uses package-lock.json) and compile assets
RUN npm ci && npm run build && rm -rf node_modules

# Set permissions for Laravel
RUN chown -R www-data:www-data /app/storage /app/bootstrap/cache

# At runtime: apply env vars → cache config/routes/views → migrate → serve
CMD ["sh", "-c", "php artisan config:cache && php artisan route:cache && php artisan view:cache && php artisan migrate --force && frankenphp php-server --listen :$PORT -r public"]
