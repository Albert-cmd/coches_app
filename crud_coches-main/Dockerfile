#FROM php:5.6-apache
FROM php:7.4-apache
RUN requirements="libmcrypt4 libmcrypt-dev libcurl3-dev libxml2-dev libxslt-dev libpng-dev libjpeg-dev libfreetype6-dev libzip-dev git wget" \
    && apt-get update && apt-get install -y $requirements && rm -rf /var/lib/apt/lists/*

RUN a2enmod rewrite

RUN docker-php-ext-install pdo mysqli pdo_mysql zip;

ENV APACHE_DOCUMENT_ROOT=/var/www/html
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf
RUN chmod -R 777 /var/www/html/

RUN requirementsToRemove="libmcrypt-dev libcurl3-dev libxml2-dev" \
    && apt-get purge --auto-remove -y $requirementsToRemove \
    && echo "date.timezone = Europe/Madrid" > /usr/local/etc/php/php.ini \
    && echo "date.timezone = Europe/Madrid" > /usr/local/etc/php/php.ini \
    && echo "error_reporting = E_ALL & ~E_NOTICE & ~E_WARNING & ~E_DEPRECATED" >> /usr/local/etc/php/php.ini
EXPOSE 84