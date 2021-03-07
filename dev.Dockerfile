FROM php:8.0.2-cli

RUN apt-get -y update && apt-get -y autoclean && apt-get install -y \
  git \
  curl \
  nano \
  zip \
  unzip \
  openssl

# Install Redis
RUN pecl install -o -f redis && docker-php-ext-enable redis

# Install xdebug
RUN pecl install xdebug && docker-php-ext-enable xdebug

# Install stryng types validation methodes for better symfony performence
RUN docker-php-ext-install ctype

# Download symfony CLI
RUN curl -sS https://get.symfony.com/cli/installer | bash
RUN mv /root/.symfony/bin/symfony /usr/local/bin/symfony

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer
