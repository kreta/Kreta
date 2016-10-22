#!/usr/bin/env bash

bin/task-manager-console doctrine:database:drop --force
bin/task-manager-console doctrine:database:create
bin/task-manager-console doctrine:schema:update --force
