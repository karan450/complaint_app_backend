# Use the official PHP image with Apache preinstalled
FROM php:8.2-apache

# Copy all your API files into the Apache web directory
COPY . /var/www/html/

# Install mysqli extension so PHP can talk to your MySQL DB
RUN docker-php-ext-install mysqli

# Enable Apache mod_rewrite (helps with clean URLs)
RUN a2enmod rewrite

# Set working directory
WORKDIR /var/www/html/

# Expose port 80 for HTTP traffic
EXPOSE 80
