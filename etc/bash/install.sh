#!/usr/bin/env bash

cd SharedKernel
composer install
cd ..

cd IdentityAccess
composer install
cd ..
sh IdentityAccess/etc/bash/generate_ssh_keys.sh
sh IdentityAccess/etc/bash/load_database.sh

cd TaskManager
composer install
cd ..
sh TaskManager/etc/bash/load_database.sh
