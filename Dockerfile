FROM php:8.2-apache

# Install extensions needed for Laravel
RUN docker-php-ext-install pdo pdo_mysql

# Copy project files
COPY . /var/www/html

# Set working directory
WORKDIR /var/www/html

# Set permissions for Laravel storage and cache
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Point Apache document root to Laravel's public folder
RUN sed -i 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf

# Enable Apache mod_rewrite for Laravel routing
RUN a2enmod rewrite

EXPOSE 80

CMD ["apache2-foreground"]
