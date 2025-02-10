FROM dunglas/frankenphp
 
# Install PHP extensions
RUN install-php-extensions \
    pcntl \
    zip \
    pdo_mysql \

 
COPY . /app
 
ENTRYPOINT ["php", "artisan", "octane:frankenphp"]