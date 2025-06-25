# Dockerfile for PHP project
FROM php:8.1-apache

# Install mysqli extension
RUN docker-php-ext-install mysqli

RUN groupadd -g 1000 appuser && useradd -u 1000 -g appuser -m appuser
# Copy project files to the web root
COPY . /var/www/html/
# Set correct permissions (optional but recommended)
RUN chown -R www-data:www-data /var/www/html

USER appuser

# Expose Apache port
EXPOSE 80
