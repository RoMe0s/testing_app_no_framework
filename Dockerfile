FROM php:7.4-fpm-alpine

RUN docker-php-ext-install pdo_mysql

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN addgroup -g 1000 -S php && \
    adduser -u 1000 -S php -G php

USER php

EXPOSE 9000

CMD ["php-fpm"]

