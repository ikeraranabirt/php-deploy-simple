FROM php:8.3-cli

# Carpeta base dentro del contenedor
WORKDIR /app

# Copiamos TODO el repo dentro del contenedor (incluye src/, vendor/, composer.json...)
COPY . /app

CMD php -S 0.0.0.0:$PORT -t /app/public /app/router.php
