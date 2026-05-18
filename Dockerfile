
# 1. Usamos una imagen oficial de PHP con Apache preconfigurado
FROM php:8.2-apache

# 2. Instalar dependencias del sistema y extensiones de PHP requeridas para Laravel y SQLite
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    unzip \
    git \
    curl \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd zip pdo pdo_mysql bcmath

# 3. Instalar NodeJS y NPM (necesario para compilar tus estilos con Vite)
RUN curl -sL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs

# 4. Instalar Composer de forma global
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 5. Configurar Apache para que apunte directamente a la carpeta /public de Laravel
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf
RUN a2enmod rewrite

# 6. Definir el directorio de trabajo y copiar el proyecto completo
WORKDIR /var/www/html
COPY . .

# 7. Instalar las dependencias de PHP (sin entorno de desarrollo)
RUN composer install --no-dev --optimize-autoloader

# 8. Instalar dependencias de Node y compilar los recursos de Vite para producción
RUN npm install && npm run build

# 9. Asignar los permisos necesarios para que Laravel pueda escribir logs y caché
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# 10. Comando de inicio: crea la base de datos SQLite, ejecuta migraciones, seeders y enciende Apache
CMD touch database/database.sqlite \
    && chown www-data:www-data database/database.sqlite \
    && php artisan migrate --force \
    && php artisan db:seed --force \
    && apache2-foreground
