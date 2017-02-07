# This file is part of the Kreta package.
#
# (c) Beñat Espiña <benatespina@gmail.com>
# (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
#
# For the full copyright and license information, please view the LICENSE
# file that was distributed with this source code.

FROM nginx:1.11.9

MAINTAINER Kreta <kreta@kreta.io>

ADD nginx.conf /etc/nginx/
ADD compositeui.conf /etc/nginx/sites-available/
ADD taskmanager.conf /etc/nginx/sites-available/
ADD identityaccess.conf /etc/nginx/sites-available/

RUN mkdir /etc/nginx/sites-enabled
RUN ln -s /etc/nginx/sites-available/compositeui.conf /etc/nginx/sites-enabled/compositeui
RUN ln -s /etc/nginx/sites-available/taskmanager.conf /etc/nginx/sites-enabled/taskmanager
RUN ln -s /etc/nginx/sites-available/identityaccess.conf /etc/nginx/sites-enabled/identityaccess

RUN echo "upstream php-upstream { server php:9000; }" > /etc/nginx/conf.d/upstream.conf

RUN usermod -u 1000 www-data

CMD ["nginx"]

EXPOSE 80
EXPOSE 443
