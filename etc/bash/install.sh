#!/usr/bin/env bash

cd SharedKernel
composer install
cd ..

cd IdentityAccess
composer install
sh etc/bash/generate_ssh_keys.sh
sh etc/bash/load_database.sh
cd ..

cd TaskManager
composer install
sh etc/bash/load_database.sh
cd ..
