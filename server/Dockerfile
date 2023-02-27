# Set the base image to the official PHP 8.1 image
FROM php:8.1-fpm-alpine

# Install required PHP extensions and dependencies
RUN apk add --no-cache postgresql-dev \
    && docker-php-ext-install pdo pdo_pgsql

# Set working directory
WORKDIR /var/www/html

# Copy the Laravel application to the container
COPY . .
COPY .env.example .env

# Install Composer and run it to install dependencies
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer install
RUN php artisan key:generate

# Set file permissions
RUN chown -R www-data:www-data storage bootstrap/cache

# Set environment variables for PostgreSQL connection
ENV DB_CONNECTION=${DB_CONNECTION}
ENV DB_HOST=${DB_HOST}
ENV DB_PORT=${DB_PORT}
ENV DB_DATABASE=${DB_DATABASE}
ENV DB_USERNAME=${DB_USERNAME}
ENV DB_PASSWORD=${DB_PASSWORD}

## Execute projectcopy ./run.sh /tmp
COPY ./run.sh /tmp
ENTRYPOINT ["/tmp/run.sh"]
EXPOSE 8000
