FROM php:8.2-apache

# Extensão mysqli usada para ligar à base de dados
RUN docker-php-ext-install mysqli

# Configuração PHP: output_buffering permite session_start()/header() depois de HTML
COPY docker/php.ini /usr/local/etc/php/conf.d/lisboaperto.ini

COPY . /var/www/html/
RUN mkdir -p /var/www/html/uploads && chown -R www-data:www-data /var/www/html/uploads
