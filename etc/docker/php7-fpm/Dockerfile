# This file is part of the Kreta package.
#
# (c) Beñat Espiña <benatespina@gmail.com>
# (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
#
# For the full copyright and license information, please view the LICENSE
# file that was distributed with this source code.

FROM php:7.0-fpm

MAINTAINER Gorka Laucirica <gorka.lauzirika@gmail.com>

RUN apt-get update && apt-get install -y \
    git \
    unzip

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer --version

# Set timezone
RUN rm /etc/localtime
RUN ln -s /usr/share/zoneinfo/Europe/Paris /etc/localtime
RUN "date"

# Type docker-php-ext-install to see available extensions
RUN docker-php-ext-install pdo pdo_mysql
RUN docker-php-ext-install bcmath

RUN mkdir /var/www/vendor-taskmanager
RUN mkdir /var/www/vendor-identityaccess
RUN mkdir /var/www/identityaccess
RUN mkdir /var/www/taskmanager

RUN cd /var/www/taskmanager && ln -s ../vendor-taskmanager/ vendor
RUN cd /var/www/identityaccess && ln -s ../vendor-identityaccess/ vendor

WORKDIR /var/www/taskmanager

RUN echo 'alias sf="php etc/bin/symfony-console"' >> ~/.bashrc
