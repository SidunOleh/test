FROM php:8.2-fpm-alpine

WORKDIR /var/www/php

CMD [ "php", "-S", "0.0.0.0:5000" ]