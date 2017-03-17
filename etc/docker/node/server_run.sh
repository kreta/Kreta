#!/usr/bin/env bash

until cd /var/www/compositeui && yarn install
do
    echo "Retrying yarn install"
done
rm -rf node_modules/.cache/babel-loader/*
echo "Babel loader cache cleared"
yarn start
