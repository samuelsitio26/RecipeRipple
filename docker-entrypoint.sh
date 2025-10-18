#!/bin/bash
set -e

echo "🚀 Starting RecipeRipple deployment..."

# Wait for database to be ready
echo "⏳ Waiting for database connection..."
until php artisan db:show 2>/dev/null; do
    echo "Database not ready, retrying in 2 seconds..."
    sleep 2
done

echo "✅ Database connected!"

# Run migrations
echo "🗄️  Running database migrations..."
php artisan migrate --force

# Optional: Run seeders (comment out if not needed)
# echo "🌱 Running database seeders..."
# php artisan db:seed --force

echo "✅ Migration completed!"

# Start FrankenPHP server
echo "🐘 Starting FrankenPHP server..."
exec frankenphp php-server --listen :8080
