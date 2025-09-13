FROM php:8.4-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libicu-dev \
    libzip-dev \
    libonig-dev \
    zip \
    && docker-php-ext-install intl pdo_mysql zip

# Install Symfony CLI
RUN curl -sS https://get.symfony.com/cli/installer | bash \
    && mv /root/.symfony*/bin/symfony /usr/local/bin/symfony


# Set working directory
WORKDIR /var/www/symfony

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
