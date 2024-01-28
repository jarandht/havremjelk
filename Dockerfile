FROM php:8.0-apache

COPY ./data /var/www/html/

# Install mysqli extension
RUN docker-php-ext-install mysqli

# Install php-mysql package
RUN apt-get update && apt-get install -y libpq-dev && docker-php-ext-install pdo pdo_mysql

# Enable the mysqli extension
RUN docker-php-ext-enable mysqli

# Clean up
RUN apt-get clean && rm -rf /var/lib/apt/lists/*