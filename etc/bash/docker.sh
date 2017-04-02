#!/usr/bin/env bash

# This file is part of the Kreta package.
#
# (c) Beñat Espiña <benatespina@gmail.com>
# (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
#
# For the full copyright and license information, please view the LICENSE
# file that was distributed with this source code.

cd $(dirname $0)/../docker
if [ ! -f .env ]; then
 echo "Creating Enviroment for docker"
 cp .env.dist .env
fi
docker-compose up -d || docker-compose up -d
docker-compose exec php bash -c "cd /var/www/taskmanager && composer install --no-interaction"
docker-compose exec php bash -c "cd /var/www/identityaccess && composer install --no-interaction"
docker-compose exec php bash -c "cd /var/www/identityaccess/var && chown www-data:www-data * && rm -rf cache/*"
docker-compose exec php bash -c "cd /var/www/taskmanager/var && chown www-data:www-data * && rm -rf cache/*"
docker-compose exec php bash -c "cd /var/www/identityaccess && sh etc/bash/generate_ssh_keys.sh"
docker-compose exec php bash -c "cd /var/www/taskmanager && etc/bin/symfony-console doctrine:da:cr"
docker-compose exec php bash -c "cd /var/www/taskmanager && etc/bin/symfony-console doctrine:mi:mi --no-interaction"
docker-compose exec php bash -c "cd /var/www/identityaccess && etc/bin/symfony-console doctrine:da:cr"
docker-compose exec php bash -c "cd /var/www/identityaccess && etc/bin/symfony-console doctrine:mi:mi --no-interaction"

while getopts 'f' flag; do
  case "${flag}" in
    f)
      docker-compose exec php bash -c "cd /var/www/taskmanager && sh etc/bash/load_fixtures.sh"
      docker-compose exec php bash -c "cd /var/www/identityaccess && sh etc/bash/load_fixtures.sh" ;;
    *) error "Unexpected option ${flag}" ;;
  esac
done

nohup docker-compose exec php bash -c "cd /var/www/taskmanager && etc/bin/symfony-console rabbitmq:consumer asynchronous_events" </dev/null >/dev/null 2>&1
