FROM php:8.3-cli

WORKDIR /app

COPY . /app

CMD php -S 0.0.0.0:$PORT -t /app/public /app/router.php


