# 1. Partimos de la imagen oficial de PHP 8.3
FROM php:8.3

# 2. Carpeta de trabajo dentro del contenedor
WORKDIR /app

# 3. Copiamos TODO el proyecto dentro del contenedor, a /app
COPY . /app

# 4. Comando que se ejecutará al arrancar el contenedor
#    Inicia el servidor embebido de PHP escuchando en el puerto $PORT
CMD php -S 0.0.0.0:$PORT -t /app
