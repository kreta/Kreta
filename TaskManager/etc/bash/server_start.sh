#!/usr/bin/env bash

$(dirname $0)/../bin/symfony-console server:start 127.0.0.1:8001 \
    --docroot=src/Kreta/TaskManager/Infrastructure/Ui/Http/Symfony/public \
    --force
