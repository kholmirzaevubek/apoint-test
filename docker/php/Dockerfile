FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libzip-dev \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

RUN pecl install redis && docker-php-ext-enable redis

WORKDIR /var/www/html

COPY composer.json composer.lock ./

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN composer install --no-dev --no-interaction --prefer-dist --no-scripts --no-progress || true

COPY . .

RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

USER www-data

CMD ["php-fpm"]
