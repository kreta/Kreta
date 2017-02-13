#!/usr/bin/env bash

cd $(dirname $0)/../docker
cp .env.dist .env || echo "Previosuly created env"
docker-compose up -d || docker-compose up -d
docker-compose exec php bash -c "cd /var/www/taskmanager && composer install"
docker-compose exec php bash -c "cd /var/www/identityaccess && composer install"
docker-compose exec php bash -c "cd /var/www/identityaccess/var && chown www-data:www-data * && rm -rf cache/*"
docker-compose exec php bash -c "cd /var/www/taskmanager/var && chown www-data:www-data * && rm -rf cache/*"
docker-compose exec php bash -c "cd /var/www/identityaccess && sh etc/bash/generate_ssh_keys.sh"
docker-compose exec php bash -c "echo '172.18.0.10 identityaccess.localhost' >> /etc/hosts"
docker-compose exec php bash -c "echo '172.18.0.10 taskmanager.localhost' >> /etc/hosts"

while getopts 'df' flag; do
  case "${flag}" in
    d)
      docker-compose exec php bash -c "cd /var/www/taskmanager && etc/bin/symfony-console doctrine:da:cr"
      docker-compose exec php bash -c "cd /var/www/taskmanager && etc/bin/symfony-console doctrine:mi:mi"
      docker-compose exec php bash -c "cd /var/www/identityaccess && etc/bin/symfony-console doctrine:da:cr"
      docker-compose exec php bash -c "cd /var/www/identityaccess && etc/bin/symfony-console doctrine:mi:mi" ;;
    f)
      docker-compose exec php bash -c "cd /var/www/taskmanager && sh etc/bash/load_fixtures.sh"
      docker-compose exec php bash -c "cd /var/www/identityaccess && sh etc/bash/load_fixtures.sh" ;;
    *) error "Unexpected option ${flag}" ;;
  esac
done
