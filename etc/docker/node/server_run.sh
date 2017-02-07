#!/usr/bin/env bash

until cd /var/www/compositeui && yarn install
do
    echo "Retrying yarn install"
done
yarn run start
