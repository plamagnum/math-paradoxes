FROM php:8.2-fpm

# Встановлення системних залежностей
RUN apt-get update && apt-get install -y \
    libssl-dev \
    && rm -rf /var/lib/apt/lists/*

# Встановлення MongoDB PHP extension
RUN pecl install mongodb \
    && docker-php-ext-enable mongodb

# Встановлення робочої директорії
WORKDIR /var/www/html

# Копіювання конфігурації PHP
RUN echo "date.timezone = UTC" > /usr/local/etc/php/conf.d/timezone.ini