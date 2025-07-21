FROM php:7.4-fpm

#NO MODIFICAR. Valor por defecto si no se pasan argumentos.
ARG XDEBUG_ENV="production"

# Set working directory
WORKDIR /var/www

#Librerias
RUN apt-get update -y && \
    apt-get upgrade -y && \
    apt-get install libpng-dev -y && \
    apt-get install libldap2-dev -y && \
    apt-get install libicu-dev -y && \
    apt-get install zip -y &&\
    apt-get install libzip-dev -y &&\
    apt-get install zip -y

# Install extensions
RUN docker-php-ext-install gd
RUN docker-php-ext-install zip
RUN docker-php-ext-install intl
RUN docker-php-ext-install opcache
RUN docker-php-ext-configure intl

# Install yarn
RUN apt-get update && \
    apt-get install -y ca-certificates curl gnupg && \
    mkdir -p /etc/apt/keyrings && \
    curl -fsSL https://deb.nodesource.com/gpgkey/nodesource-repo.gpg.key | gpg --dearmor -o /etc/apt/keyrings/nodesource.gpg && \
    NODE_MAJOR=16 && \
    echo "deb [signed-by=/etc/apt/keyrings/nodesource.gpg] https://deb.nodesource.com/node_$NODE_MAJOR.x nodistro main" | tee /etc/apt/sources.list.d/nodesource.list && \
    apt-get update && \
    apt-get install nodejs -y && \
    curl -sS https://dl.yarnpkg.com/debian/pubkey.gpg | apt-key add - && \
    echo "deb https://dl.yarnpkg.com/debian/ stable main" | tee /etc/apt/sources.list.d/yarn.list && \
    apt-get update && \
    apt-get install -y --no-install-recommends yarn && \
    npm install -g npm@7.24.0

#XDEBUG
RUN pecl install xdebug-3.1.5 \
    && docker-php-ext-enable xdebug

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Expose port 9000 and start php-fpm server
EXPOSE 9000
CMD ["php-fpm"]