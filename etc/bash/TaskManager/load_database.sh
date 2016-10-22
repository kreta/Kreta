#!/usr/bin/env bash

etc/bin/task-manager-console doctrine:database:drop --force
etc/bin/task-manager-console doctrine:database:create
etc/bin/task-manager-console doctrine:migrations:migrate --no-interaction
