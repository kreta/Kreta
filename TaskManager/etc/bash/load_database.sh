#!/usr/bin/env bash

etc/bin/symfony-console doctrine:database:create
etc/bin/symfony-console doctrine:migrations:migrate --no-interaction
