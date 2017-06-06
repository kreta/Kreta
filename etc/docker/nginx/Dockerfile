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
ADD compositeui.template /etc/nginx/sites-available/
ADD taskmanager.template /etc/nginx/sites-available/
ADD identityaccess.template /etc/nginx/sites-available/
ADD notifier.template /etc/nginx/sites-available/

RUN mkdir /etc/nginx/sites-enabled

RUN echo "upstream php-upstream { server php:9000; }" > /etc/nginx/conf.d/upstream.conf

RUN usermod -u 1000 www-data

COPY server_run.sh /var/www/

CMD sh /var/www/server_run.sh

EXPOSE 80
EXPOSE 443
