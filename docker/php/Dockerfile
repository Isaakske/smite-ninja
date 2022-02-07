FROM php:8.1.2-fpm-buster

MAINTAINER Isaak De Backer <isaak.de.backer@hotmail.com>

RUN apt-get update \
    && apt-get install -y apt-transport-https gnupg2 \
    && curl -sS https://deb.nodesource.com/gpgkey/nodesource.gpg.key | apt-key add - \
    && curl -sS https://dl.yarnpkg.com/debian/pubkey.gpg | apt-key add - \
    && echo "deb https://dl.yarnpkg.com/debian/ stable main" | tee /etc/apt/sources.list.d/yarn.list \
    && curl -sL https://deb.nodesource.com/setup_16.x | bash \
    && apt-get install -y \
    && apt-get autoremove -y \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

ENV TZ=Europe/Brussels
ADD docker/php/tools /tools
RUN chmod +x -R /tools/*.sh

# Executables
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime \
    && echo $TZ > /etc/timezone \
    && apt-get update \
    && apt-get install -y --no-install-recommends wget zip unzip tar bzip2 yarn nodejs \
    && apt-get autoremove -y \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# PHP
RUN apt-get update \
    && apt-get install -y --no-install-recommends libssl-dev libicu-dev libzip-dev \
    && mv /tools/php.ini /usr/local/etc/php/ \
    && mv /tools/zzz-smite.conf /usr/local/etc/php-fpm.d/zzz-smite.conf \
    && wget http://curl.haxx.se/ca/cacert.pem -O /usr/local/etc/php/cacert.pem \
    && pecl install -o -f crypto curl \
    && docker-php-ext-install bcmath intl opcache zip calendar \
    && pecl channel-update pecl.php.net \
    && pecl install apcu \
    && rm -rf /tmp/pear \
    && apt-get autoremove -y \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Prepare composer
RUN mv /tools/install_composer.sh /usr/local/bin \
    && chmod +x /usr/local/bin/install_composer.sh \
    && /usr/local/bin/install_composer.sh

COPY composer.json composer.lock /var/vendor_install/
RUN cd /var/vendor_install \
    && composer.phar install --no-ansi --no-interaction --no-progress --no-autoloader --profile --prefer-dist --no-scripts \
    && composer.phar clear-cache

COPY . /var/www

RUN cd /var/www \
    && mv /var/vendor_install/vendor /var/www \
    && rm -rf /var/vendor_install \
    && composer.phar dump-autoload --optimize --classmap-authoritative \
    && mkdir -p var/cache \
    && mkdir -p var/log \
    && php -d memory_limit=512M bin/console cache:warmup --env=prod \
    && yarn install \
    && yarn build \
    && chmod -R 777 var/cache \
    && chmod -R 777 var/log \
    && chown -R 1000:1000 var/cache \
    && chown -R 1000:1000 var/log

WORKDIR /var/www

CMD ["/tools/entrypoint.sh"]
