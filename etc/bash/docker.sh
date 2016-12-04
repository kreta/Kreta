cd $(dirname $0)/../docker
docker-compose up -d
docker-compose exec php bash -c "cd /var/www/taskmanager && composer install"
docker-compose exec php bash -c "cd /var/www/identityaccess && composer install"
