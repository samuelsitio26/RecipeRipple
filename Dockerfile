FROM php:8.1-apacheFROM php:8.1-apacheFROM php:8.2-cli



RUN apt-get update && apt-get install -y \

    libpng-dev \

    libjpeg62-turbo-dev \# Install dependencies# Install system dependencies

    libfreetype6-dev \

    zip \RUN apt-get update && apt-get install -y \RUN apt-get update && apt-get install -y \

    unzip \

    git    libpng-dev \    git \



RUN docker-php-ext-configure gd --with-freetype --with-jpeg && \    libjpeg62-turbo-dev \    curl \

    docker-php-ext-install gd pdo pdo_mysql

    libfreetype6-dev \    libpng-dev \

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

    zip \    libonig-dev \

WORKDIR /var/www/html

    unzip \    libxml2-dev \

COPY . .

    git    zip \

RUN composer install --optimize-autoloader --no-dev

    unzip \

RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache && \

    chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache# Install PHP extensions    libzip-dev



RUN a2enmod rewriteRUN docker-php-ext-configure gd --with-freetype --with-jpeg



RUN echo 'ServerName localhost' >> /etc/apache2/apache2.confRUN docker-php-ext-install gd pdo pdo_mysql# Clear cache



RUN echo '<VirtualHost *:80>\n\RUN apt-get clean && rm -rf /var/lib/apt/lists/*

    DocumentRoot /var/www/html/public\n\

    <Directory /var/www/html/public>\n\# Install Composer

        AllowOverride All\n\

        Require all granted\n\COPY --from=composer:latest /usr/bin/composer /usr/bin/composer# Install PHP extensions

    </Directory>\n\

    ErrorLog ${APACHE_LOG_DIR}/error.log\n\RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

    CustomLog ${APACHE_LOG_DIR}/access.log combined\n\

</VirtualHost>' > /etc/apache2/sites-available/000-default.conf# Set working directory



EXPOSE 80WORKDIR /var/www/html# Install Composer



CMD ["apache2-foreground"]COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy application files

COPY . .# Set working directory

WORKDIR /var/www/html

# Install dependencies

RUN composer install --optimize-autoloader --no-dev# Copy application files

COPY . .

# Set permissions

RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache# Install PHP dependencies

RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cacheRUN composer install --no-dev --optimize-autoloader



# Configure Apache# Set permissions

RUN a2enmod rewriteRUN chmod -R 775 storage bootstrap/cache

RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Expose port

# Copy Apache configEXPOSE 8000

COPY <<EOF /etc/apache2/sites-available/000-default.conf

<VirtualHost *:80># Start command will be handled by Procfile

    DocumentRoot /var/www/html/public
    <Directory /var/www/html/public>
        AllowOverride All
        Require all granted
    </Directory>
    ErrorLog \${APACHE_LOG_DIR}/error.log
    CustomLog \${APACHE_LOG_DIR}/access.log combined
</VirtualHost>
EOF

EXPOSE 80

CMD ["apache2-foreground"]
