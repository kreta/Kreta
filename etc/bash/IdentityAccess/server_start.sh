#!/usr/bin/env bash

export SYMFONY_ENV=dev
IdentityAccess/src/Infrastructure/Ui/Cli/Symfony/console server:start 127.0.0.1:8002 --router=IdentityAccess/src/Infrastructure/Ui/Web/Symfony/public/app.php --docroot=IdentityAccess/src/Infrastructure/Ui/Web/Symfony/public
