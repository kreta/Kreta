#!/usr/bin/env bash

TaskManager/etc/bin/symfony-console doctrine:database:drop --force
TaskManager/etc/bin/symfony-console doctrine:database:create
TaskManager/etc/bin/symfony-console doctrine:migrations:migrate --no-interaction
