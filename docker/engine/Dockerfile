FROM php:7.0-apache
MAINTAINER Yassine Guedidi <yassine@guedidi.com>

ARG host_uid
ARG host_gid

RUN usermod -u "$host_uid" www-data \
    && groupmod -g "$host_gid" www-data \
    && apt-get update && apt-get install -y \
        libicu-dev \
        zlib1g-dev \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug \
    && docker-php-ext-install intl mbstring opcache pdo_mysql zip \
    && curl https://raw.githubusercontent.com/composer/getcomposer.org/1b137f8bf6db3e79a38a5bc45324414a6b1f9df2/web/installer | php -- --quiet --filename=composer --install-dir=/usr/local/bin \
    && version=$(php -r "echo PHP_MAJOR_VERSION.PHP_MINOR_VERSION;") \
    && curl -A "Docker" -o /tmp/blackfire-probe.tar.gz -D - -L -s https://blackfire.io/api/v1/releases/probe/php/linux/amd64/$version \
    && tar zxpf /tmp/blackfire-probe.tar.gz -C /tmp \
    && mv /tmp/blackfire-*.so $(php -r "echo ini_get('extension_dir');")/blackfire.so \
    && printf "extension=blackfire.so\nblackfire.agent_socket=tcp://blackfire:8707\n" > $PHP_INI_DIR/conf.d/blackfire.ini \
    && curl -o blackfire -L https://packages.blackfire.io/binaries/blackfire-agent/1.9.2/blackfire-cli-linux_amd64 \
    && chmod +x blackfire \
    && mv blackfire /usr/local/bin/blackfire

RUN a2enmod rewrite
RUN a2enmod ssl

COPY ./alwaysdata.crt /etc/ssl/certs/alwaysdata.crt
COPY ./alwaysdata.key /etc/ssl/private/alwaysdata.key
COPY ./alwaysdata.conf /etc/apache2/sites-available/000-default.conf
COPY php.ini /usr/local/etc/php/conf.d/custom.ini
