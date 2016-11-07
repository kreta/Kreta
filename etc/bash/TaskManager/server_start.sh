#!/usr/bin/env bash

export SYMFONY_ENV=dev
TaskManager/src/Infrastructure/Ui/Cli/Symfony/console server:start 127.0.0.1:8001 --router=TaskManager/src/Infrastructure/Ui/Http/Symfony/public/app.php --docroot=TaskManager/src/Infrastructure/Ui/Http/Symfony/public
