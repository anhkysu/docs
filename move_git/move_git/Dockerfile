FROM php:7.2-apache

RUN apt-get update

RUN apt-get install -y \
    git \
    zip \
    curl \
    sudo \
    unzip \
    libicu-dev \
    libbz2-dev \
    libpng-dev \
    libjpeg-dev \
    libmcrypt-dev \
    libreadline-dev \
    libfreetype6-dev \
    g++

COPY . /var/www/html

RUN cp /var/www/html/deployment/application.conf /etc/apache2/sites-available/
RUN cp /var/www/html/deployment/ports.conf /etc/apache2/ports.conf

#ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
#RUN sed -ri -e 's!/var/www/html/var/www/html/public/g' /etc/apache2/sites-available/*.conf
#RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

#3. mod_rewrite for URL rewrite and mod_headres for .htaccess extra headers like Access-Control-Allo-Origin
RUN a2enmod rewrite headers

RUN a2ensite application.conf
RUN a2enmod rewrite

# 4. at initialized time, php is pushed in to container, php.ini-development is default value,
# clone it to php.ini for php engine be executed with desirable configuration
RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"

# 5. install extensions
RUN docker-php-ext-install \
    bz2 \
    intl \
    iconv \
    bcmath \
    opcache \
    calendar \
    mbstring \
    pdo_mysql \
    zip

# 6. we need a user with the same UID/GID with host user
# so when we execute CLI commands, all the host file's ownership remains intact
# otherwise command from inside container will create root-owned files and directories
ARG uid
RUN useradd -G www-data,root -u $uid -d /home/devuser devuser
RUN mkdir -p /home/devuser/.composer && \
    chown -R devuser:devuser /home/devuser


#RUN apt-get update && apt-get install -y iputils-ping
#CMD bash