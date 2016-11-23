#!/usr/bin/env bash

export SYMFONY_ENV=dev
etc/bin/symfony-console server:start 127.0.0.1:8001 --router=src/Kreta/TaskManager/Infrastructure/Ui/Http/Symfony/public/app.php --docroot=src/Kreta/TaskManager/Infrastructure/Ui/Http/Symfony/public
