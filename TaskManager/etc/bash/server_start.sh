#!/usr/bin/env bash

export SYMFONY_ENV=dev
TaskManager/etc/bin/symfony-console server:start 127.0.0.1:8001 --router=TaskManager/src/Kreta/TaskManager/Infrastructure/Ui/Http/Symfony/public/app.php --docroot=TaskManager/src/Kreta/TaskManager/Infrastructure/Ui/Http/Symfony/public
