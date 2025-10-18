#!/bin/bash
set -e

echo "🚀 Starting RecipeRipple deployment..."

# Print environment info for debugging
echo "📋 Environment: APP_ENV=$APP_ENV"
echo "📋 Database Config:"
echo "   DB_HOST=$DB_HOST"
echo "   DB_PORT=$DB_PORT"
echo "   DB_DATABASE=$DB_DATABASE"
echo "   DB_USERNAME=$DB_USERNAME"

# Simple database connection test with timeout
echo "⏳ Testing database connection..."
timeout=60
counter=0

while [ $counter -lt $timeout ]; do
    if php -r "
        try {
            \$pdo = new PDO('mysql:host='.\$_ENV['DB_HOST'].';port='.\$_ENV['DB_PORT'].';dbname='.\$_ENV['DB_DATABASE'], \$_ENV['DB_USERNAME'], \$_ENV['DB_PASSWORD']);
            echo 'OK';
            exit(0);
        } catch (Exception \$e) {
            exit(1);
        }
    " 2>/dev/null; then
        echo "✅ Database connected!"
        break
    fi

    echo "Database not ready, retrying... ($counter/$timeout)"
    sleep 2
    counter=$((counter + 2))
done

if [ $counter -ge $timeout ]; then
    echo "❌ Database connection timeout after ${timeout}s"
    echo "⚠️  Starting server without migrations (check logs for errors)"
else
    # Run migrations
    echo "🗄️  Running database migrations..."
    if php artisan migrate --force; then
        echo "✅ Migrations completed!"

        # Run seeders
        echo "🌱 Running database seeders..."
        if php artisan db:seed --force; then
            echo "✅ Seeders completed!"
        else
            echo "⚠️  Seeding failed or skipped"
        fi
    else
        echo "❌ Migration failed!"
    fi
fi

# Start FrankenPHP server
echo "🐘 Starting FrankenPHP server on :8080..."
exec frankenphp php-server --listen :8080
