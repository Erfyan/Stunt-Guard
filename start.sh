#!/bin/bash
set -e

echo "=== Clearing Config ==="
php artisan config:clear

echo "=== Running Migrations ==="
php artisan migrate --force

echo "=== Running Seeders ==="
php artisan db:seed --force

echo "=== Starting Apache ==="
apache2-foreground
