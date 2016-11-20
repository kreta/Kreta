#!/usr/bin/env bash

IdentityAccess/etc/bin/symfony-console doctrine:database:drop --force
IdentityAccess/etc/bin/symfony-console doctrine:database:create
IdentityAccess/etc/bin/symfony-console doctrine:migrations:migrate --no-interaction
