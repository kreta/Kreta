# This file is part of the Kreta package.
#
# (c) Beñat Espiña <benatespina@gmail.com>
# (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
#
# For the full copyright and license information, please view the LICENSE
# file that was distributed with this source code.

FROM node:7

MAINTAINER Gorka Laucirica <gorka.lauzirika@gmail.com>

RUN npm -g install yarn

WORKDIR /var/www/compositeui

COPY server_run.sh /var/www/

EXPOSE 3000

CMD sh /var/www/server_run.sh
