#!/bin/bash

# Railway Deployment Script
echo "🚀 Starting deployment process..."

# Install dependencies
echo "📦 Installing Composer dependencies..."
composer install --no-dev --optimize-autoloader

# Install Node dependencies and build assets
echo "🎨 Building frontend assets..."
npm ci
npm run build

# Generate Laravel key if not exists
echo "🔑 Generating application key..."
php artisan key:generate --force

# Run database migrations
echo "🗃️ Running database migrations..."
php artisan migrate --force

# Seed database if needed (optional)
# php artisan db:seed --force

# Clear and cache configurations
echo "⚡ Optimizing application..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Set proper permissions
echo "🔒 Setting permissions..."
chmod -R 775 storage bootstrap/cache

echo "✅ Deployment completed successfully!"
