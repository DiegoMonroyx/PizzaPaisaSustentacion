#FROM php:8.1-apache

RUN docker-php-ext-install mysqli
RUN a2enmod rewrite

RUN echo '<Directory /var/www/html>\nOptions Indexes FollowSymLinks\nAllowOverride All\nRequire all granted\n</Directory>' > /etc/apache2/conf-available/enable-indexes.conf
RUN a2enconf enable-indexes

COPY  /var/www/html/

RUN chown -R www-data:www-data /var/www/html

EXPOSE 80
