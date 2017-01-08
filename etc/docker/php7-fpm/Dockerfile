# This file is part of the Kreta package.
#
# (c) Beñat Espiña <benatespina@gmail.com>
# (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
#
# For the full copyright and license information, please view the LICENSE
# file that was distributed with this source code.

FROM php:7.1-fpm

MAINTAINER Gorka Laucirica <gorka.lauzirika@gmail.com>

RUN apt-get update && apt-get install -y \
    git \
    unzip

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer --version

# Set timezone
RUN rm /etc/localtime
RUN ln -s /usr/share/zoneinfo/Europe/Madrid /etc/localtime
RUN "date"

# Type docker-php-ext-install to see available extensions
RUN docker-php-ext-install pdo pdo_mysql
RUN docker-php-ext-install bcmath

RUN mkdir /var/www/vendor-taskmanager
RUN mkdir /var/www/vendor-identityaccess

COPY taskmanager-composer.lock /var/www/taskmanager/composer.lock
COPY taskmanager-composer.json /var/www/taskmanager/composer.json
RUN cd /var/www/taskmanager && composer install

COPY identityaccess-composer.lock /var/www/identityaccess/composer.lock
COPY identityaccess-composer.json /var/www/identityaccess/composer.json
RUN cd /var/www/identityaccess && composer install

WORKDIR /var/www/taskmanager

RUN echo 'alias sf="php etc/bin/symfony-console"' >> ~/.bashrc
