# Docker for Kreta

This complete stack run with docker and [docker-compose (1.7 or higher)](https://docs.docker.com/compose/).

It provides the following containers:

* Nginx
* MySQL
* PHP7-FPM
* RabbitMQ
* Node

## Installation

1. Copy the file located at `<kreta-root>/etc/docker/.env.dist` to `<kreta-root>/etc/docker/.env` and change the values
according to your needs.

2. Update your system host file

    Add this line to /etc/hosts 
    ```bash
    127.0.0.1 kreta.localhost taskmanager.localhost identityaccess.localhost
    ```

3. Execute this command 

    ```
    sh etc/bash/docker.sh [-f This optional flag load fixtures with fake data]
    ```

4. Enjoy :-)

* Symfony app: visit [kreta.localhost](http://kreta.localhost). If you get 502 visit Known Issues at bottom

## How it works?

Have a look at the `docker-compose.yml` file, here are the `docker-compose` built images:

* `db`: This is the MySQL database container,
* `php`: This is the PHP-FPM container in which the application volume is mounted,
* `nginx`: This is the Nginx webserver container in which application volume is mounted too,
* `rabbitmq`: This is a rabbitmq container.
* `node`: This is a the node container.

This results in the following running containers:

```bash
$ docker-compose ps
      Name                     Command               State                                             Ports
-------------------------------------------------------------------------------------------------------------------------------------------------------
docker_db_1         docker-entrypoint.sh mysqld      Up      0.0.0.0:3307->3306/tcp
docker_nginx_1      /bin/sh -c sh /var/www/ser ...   Up      443/tcp, 0.0.0.0:80->80/tcp
docker_node_1       /bin/sh -c sh /var/www/ser ...   Up      0.0.0.0:3000->3000/tcp
docker_php_1        docker-php-entrypoint php-fpm    Up      0.0.0.0:9000->9000/tcp
docker_rabbitmq_1   docker-entrypoint.sh rabbi ...   Up      15671/tcp, 0.0.0.0:15672->15672/tcp, 25672/tcp, 4369/tcp, 5671/tcp, 0.0.0.0:5672->5672/tcp
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
* Sometimes logs, cache and sessions cannot be written due to permission issues, change `var` folder permissions to 777
* Node takes some time to up, if browser brings you 502 try again few minutes later
* If you have some infrastructure installed locally (MySQL, RabbitMQ, WebServer...) you'll get an error indicating that port is already allocated

## FAQ

* How to config Xdebug?
Xdebug is configured out of the box!
Just config your IDE to connect port `9001` and id key `PHPSTORM`

* I get "Error in Missing binding /var/www/compositeui/node_modules/node-sass/vendor/linux-x64-51/binding.node"
Just run `docker-compose exec node bash -c "npm rebuild node-sass`
If it does not work, delete node_module folder and run `docker-compose exec node bash -c "npm install`
