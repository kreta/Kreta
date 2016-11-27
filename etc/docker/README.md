# Docker for Kreta

This complete stack run with docker and [docker-compose (1.7 or higher)](https://docs.docker.com/compose/).

It provides the following containers:

* Nginx
* MySQL
* PHP7-FPM
* Elastic-Logstash-Kibana (ELK)
* Redis
* RabbitMQ
* Data volumes (for db and app data)

## Installation

1. Create a `.env` from the `.env.dist` file. Adapt it according to your symfony application

    ```bash
    cp .env.dist .env
    ```


2. Build/run containers with (with and without detached mode)

    ```bash
    $ docker-compose build
    $ docker-compose up -d
    ```

3. Update your system host file (add symfony.dev)

    ```bash
    $ sudo echo "127.0.0.1 kreta.localhost" >> /etc/hosts
    ```

4. Prepare Symfony app
    1. Update TaskManager/parameters.yml

        ```yml
        parameters:
            task_manager_database_host: db_1
            task_manager_database_port: 3306
            task_manager_database_name: kreta_task_manager
            task_manager_database_user: root
            task_manager_database_password: root
        ```

    2. Update IdentityAccess/parameters.yml

        ```yml
        parameters:
            task_manager_database_host: db_1
            task_manager_database_port: 3306
            task_manager_database_name: kreta_identity_access
            task_manager_database_user: root
            task_manager_database_password: root
        ```

    3. Composer install & create database

        ```bash
        $ docker-compose exec php bash
        $ composer install
        $ sh etc/bash/TaskManager/load_database.sh
        ```

5. Enjoy :-)

## Usage

Just run `docker-compose -d`, then:

* Symfony app: visit [kreta.localhost](http://kreta.localhost)
* Logs (Kibana): [kreta.localhost:81](http://kreta.localhost:81)

## How it works?

Have a look at the `docker-compose.yml` file, here are the `docker-compose` built images:

* `dbdata`: This is a volume container for mysql,
* `appdata`: This is a volume container for data required to the symfony app to run,
* `db`: This is the MySQL database container,
* `php`: This is the PHP-FPM container in which the application volume is mounted,
* `nginx`: This is the Nginx webserver container in which application volume is mounted too,
* `elk`: This is a ELK stack container which uses Logstash to collect logs, send them into Elasticsearch and visualize them with Kibana,
* `redis`: This is a redis database container.
* `rabbitmq`: This is a rabbitmq container.

This results in the following running containers:

```bash
$ docker-compose ps
      Name                     Command               State                                              Ports
--------------------------------------------------------------------------------------------------------------------------------------------------------
docker_appdata_1    sh                               Exit 0
docker_db_1         docker-entrypoint.sh mysqld      Up       0.0.0.0:3306->3306/tcp
docker_dbdata_1     sh                               Exit 0
docker_elk_1        /usr/bin/supervisord -n -c ...   Up       0.0.0.0:81->80/tcp
docker_nginx_1      nginx                            Up       443/tcp, 0.0.0.0:80->80/tcp
docker_php_1        php-fpm                          Up       0.0.0.0:9000->9000/tcp
docker_rabbitmq_1   docker-entrypoint.sh rabbi ...   Up       15671/tcp, 0.0.0.0:15672->15672/tcp, 25672/tcp, 4369/tcp, 5671/tcp, 0.0.0.0:5672->5672/tcp
docker_redis_1      docker-entrypoint.sh redis ...   Up       0.0.0.0:6379->6379/tcp
```

## Useful commands

```bash
# bash commands
$ docker-compose exec php bash

# Composer (e.g. composer update)
$ docker-compose exec php composer install
$ docker-compose exec php composer update

# Symfony commands using aliases (from inside the php contanier)
$ docker-compose exec php bash
$ task-manager cache:clear
$ identity-access cache:clear

# MySQL commands
$ docker-compose exec db mysql -uroot -p"root"

# Redis commands
$ docker-compose exec redis redis-cli

# Check CPU consumption
$ docker stats $(docker inspect -f "{{ .Name }}" $(docker ps -q))

# Delete all containers
$ docker rm $(docker ps -aq)

# Delete all images
$ docker rmi $(docker images -q)
```

## Known issues

* Database requires root connection to create multiple databases
* Logs, cache and sessions cannot be written due to permission issues, change `var` folder permissions to 777
* Symfony app vendor folder needs to be symlinked manually inside the php container. Run `ln -sf /vendor ./vendor` and
run `composer install` from inside the container

## FAQ

* How to config Xdebug?
Xdebug is configured out of the box!
Just config your IDE to connect port  `9001` and id key `PHPSTORM`
