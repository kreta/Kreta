#!/usr/bin/env bash

etc/bin/identity-access-console doctrine:database:drop --force
etc/bin/identity-access-console doctrine:database:create
etc/bin/identity-access-console doctrine:migrations:migrate --no-interaction
