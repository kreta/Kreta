# Docker for Kreta

This complete stack run with docker and [docker-compose (1.7 or higher)](https://docs.docker.com/compose/).

It provides the following containers:

* Nginx
* MySQL
* PHP7-FPM
* RabbitMQ

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
    $ sudo echo "127.0.0.1 kreta.localhost taskmanager.localhost identityaccess.localhost" >> /etc/hosts
    ```

4. Prepare Symfony app
    1. Update TaskManager/parameters.yml

        ```yml
        parameters:
            task_manager_database_host: db
            task_manager_database_port: 3306
            task_manager_database_name: kreta_task_manager
            task_manager_database_user: root
            task_manager_database_password: root
        ```

    2. Update IdentityAccess/parameters.yml

        ```yml
        parameters:
            identity_access_database_host: db
            identity_access_database_port: 3306
            identity_access_database_name: kreta_identity_access
            identity_access_database_user: root
            identity_access_database_password: root
        ```

    3. Composer install & create database

        ```bash
        $ docker-compose exec php bash -c "cd /var/www/taskmanager && composer install"
        $ docker-compose exec php bash -c "cd /var/www/identityaccess && composer install"
        ```

5. Enjoy :-)

## Usage

Just run `docker-compose -d`, then:

* Symfony app: visit [kreta.localhost](http://kreta.localhost)

## How it works?

Have a look at the `docker-compose.yml` file, here are the `docker-compose` built images:

* `db`: This is the MySQL database container,
* `php`: This is the PHP-FPM container in which the application volume is mounted,
* `nginx`: This is the Nginx webserver container in which application volume is mounted too,
* `rabbitmq`: This is a rabbitmq container.

This results in the following running containers:

```bash
$ docker-compose ps
      Name                     Command               State                                              Ports
--------------------------------------------------------------------------------------------------------------------------------------------------------
docker_db_1         docker-entrypoint.sh mysqld      Up       0.0.0.0:3306->3306/tcp
docker_nginx_1      nginx                            Up       443/tcp, 0.0.0.0:80->80/tcp
docker_php_1        php-fpm                          Up       0.0.0.0:9000->9000/tcp
docker_rabbitmq_1   docker-entrypoint.sh rabbi ...   Up       15671/tcp, 0.0.0.0:15672->15672/tcp, 25672/tcp, 4369/tcp, 5671/tcp, 0.0.0.0:5672->5672/tcp
```

## Useful commands

```bash
# bash commands
$ docker-compose exec php bash

# Symfony commands using aliases (from inside the php contanier)
$ docker-compose exec php bash
$ cd /var/www/taskmanager && sf cache:clear
$ cd /var/www/identityaccess && sf cache:clear

# MySQL commands
$ docker-compose exec db mysql -uroot -p"root"

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

## FAQ

* How to config Xdebug?
Xdebug is configured out of the box!
Just config your IDE to connect port `9001` and id key `PHPSTORM`
