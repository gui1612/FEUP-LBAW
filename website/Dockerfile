FROM ubuntu:22.04

# Install dependencies
ENV DEBIAN_FRONTEND=noninteractive
RUN apt-get update 
# RUN apt-get install -y --no-install-recommends curl

# RUN curl -fsSL https://deb.nodesource.com/setup_18.x
RUN apt-get install -y --no-install-recommends \
    libpq-dev \
    vim \
    nginx \
    php8.1-fpm \
    php8.1-mbstring \
    php8.1-xml \
    php8.1-pgsql \
    php8.1-curl
    # nodejs 

WORKDIR /var/www

# Copy project code and install project dependencies
# COPY --chown=www-data composer.json composer.lock ./
# RUN composer install

# COPY --chown=www-data package.json package-lock.json ./
# RUN npm install

COPY --chown=www-data . .

# Copy project configurations
COPY ./etc/php/php.ini /usr/local/etc/php/conf.d/php.ini
COPY ./etc/nginx/default.conf /etc/nginx/sites-enabled/default
COPY .env .
COPY docker_run.sh /docker_run.sh

# RUN npm run production

# Start command
CMD sh /docker_run.sh
