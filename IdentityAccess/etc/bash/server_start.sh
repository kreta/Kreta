#!/usr/bin/env bash

$(dirname $0)/../bin/symfony-console server:start 127.0.0.1:8002 \
    --docroot=src/Kreta/IdentityAccess/Infrastructure/Ui/Http/Symfony/public \
    --force
