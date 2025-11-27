FROM php:8.3-cli

# Carpeta base dentro del contenedor
WORKDIR /app

# Copiamos TODO el repo dentro del contenedor (incluye src/, vendor/, composer.json...)
COPY . /app

# Servidor embebido de PHP:
# - Document root: /app/src/public
# - Router script: /app/src/router.php
CMD php -S 0.0.0.0:$PORT -t /app/src/public /app/src/router.php
