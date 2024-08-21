FROM php:8.2-fpm-alpine

WORKDIR /var/www/test/app

CMD [ "php", "-S", "0.0.0.0:5000" ]