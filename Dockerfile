FROM php:8.2-apache

# Install system dependencies and Composer
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev
RUN docker-php-ext-install pdo pdo_mysql zip

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy project files
COPY . /var/www/html

# Set working directory
WORKDIR /var/www/html

# Run composer install with timeout increase and retry options
RUN composer config -g process-timeout 2000 \
    && composer install --no-dev --optimize-autoloader --no-interaction

# Set permissions for Laravel storage and cache
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Point Apache document root to Laravel's public folder
RUN sed -i 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf

# Enable Apache mod_rewrite for Laravel routing
RUN a2enmod rewrite

EXPOSE 80

CMD ["apache2-foreground"]