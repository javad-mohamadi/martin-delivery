FROM php:8.2-fpm-alpine

WORKDIR /var/www

# Install dependencies
RUN apk add --update --no-cache \
    build-base \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    libzip-dev \
    icu-dev \
    vim \
    unzip \
    git \
    curl \
    jpegoptim \
    optipng \
    pngquant \
    gifsicle

# Configure PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-configure zip

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql gd zip exif pcntl intl

# Clear cache
RUN rm -rf /var/cache/apk/*

# Install composer
COPY --from=composer:2.0 /usr/bin/composer /usr/bin/composer

RUN addgroup -g 1000 martin && adduser -u 1000 -G martin -s /bin/sh -D martin

# Change current user to martin
USER martin

COPY --chown=martin:martin . .


# Set appropriate permissions for directories
RUN chmod -R 755 /var/www/bootstrap/cache

# Set appropriate permissions for files
RUN chmod -R 664 /var/www/composer.json


# Expose port 9000 and start php-fpm server
EXPOSE 9000
CMD ["php-fpm"]
