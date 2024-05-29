# Usa la imagen oficial de PHP 8.2 con Apache
FROM php:8.2-apache

# Establece el directorio de trabajo
WORKDIR /var/www/html

# Instala las dependencias necesarias
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libsqlite3-dev \
    pkg-config \
    zip \
    unzip \
    git \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd \
    && docker-php-ext-install pdo pdo_sqlite

# Instala Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copia el código de la aplicación al contenedor
COPY . .

# Instala las dependencias de la aplicación
RUN composer install

# Da permisos de escritura a las carpetas de cache y logs
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Habilita el módulo de reescritura de Apache
RUN a2enmod rewrite

# Configura el directorio raíz del servidor web para que apunte a la carpeta 'public'
RUN sed -i 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf

# Expone el puerto 80
EXPOSE 80

# Comando por defecto para ejecutar Apache
CMD ["apache2-foreground"]
