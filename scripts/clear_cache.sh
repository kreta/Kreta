#!/bin/sh

# This file belongs to Kreta.
# The source code of application includes a LICENSE file
# with all information about license.
#
# @author benatespina <benatespina@gmail.com>
# @author gorkalaucirica <gorka.lauzirika@gmail.com>

echo "Do not use this in production, its dangerous"
if [ ! -d '/dev/shm/symfony/' ]; then
  mkdir /dev/shm/symfony
  mkdir /dev/shm/symfony/cache /dev/shm/symfony/logs
fi
sudo rm -rf app/cache/* app/logs/*
sudo chmod -R 777 /dev/shm/symfony/cache
sudo chmod -R 777 /dev/shm/symfony/logs/
php app/console cache:clear -e=dev
sudo chmod -R 777 /dev/shm/symfony/cache
sudo chmod -R 777 /dev/shm/symfony/logs/
