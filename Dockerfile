# Use an official PHP image as the base
FROM php:8.2-fpm

# Install dependencies
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    libsqlite3-dev \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libzip-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql pdo_sqlite zip gd

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy the project files to the working directory
COPY . .

# Install PHP dependencies
RUN composer install --prefer-dist --no-scripts --no-dev --no-progress --no-interaction

# Expose port 9000 and start php-fpm server
EXPOSE 9000

CMD ["php-fpm"]
