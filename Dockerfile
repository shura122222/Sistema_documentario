# Usa una imagen oficial de PHP con Apache
FROM php:8.2-apache

# Habilita extensiones necesarias para MySQL
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Establece el directorio de trabajo
WORKDIR /var/www/html

# Copia tu código PHP al contenedor
COPY . /var/www/html/

# Opcional: da permisos correctos a los archivos (seguridad y compatibilidad)
RUN chown -R www-data:www-data /var/www/html

# Expón el puerto 80
EXPOSE 80
