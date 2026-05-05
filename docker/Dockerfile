FROM php:8.5-cli

# Install dependencies
RUN apt-get update && apt-get install -y git unzip curl mediainfo

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app