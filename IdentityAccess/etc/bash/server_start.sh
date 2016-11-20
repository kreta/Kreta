#!/usr/bin/env bash

export SYMFONY_ENV=dev
IdentityAccess/etc/bin/symfony-console server:start 127.0.0.1:8002 --router=IdentityAccess/src/Kreta/IdentityAccess/Infrastructure/Ui/Http/Symfony/public/app.php --docroot=IdentityAccess/src/Kreta/IdentityAccess/Infrastructure/Ui/Http/Symfony/public
