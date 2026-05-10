FROM php:8.2-apache

# Install necessary extensions
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Copy all files to the container
COPY . /var/www/html/

# Set permissions
RUN chmod -R 755 /var/www/html

EXPOSE 80
