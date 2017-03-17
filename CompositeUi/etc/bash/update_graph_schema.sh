#!/usr/bin/env bash

cd ../TaskManager
etc/bin/symfony-console graph:dump-schema --file=../CompositeUi/schema.json
cd -
rm -rf node_modules/.cache/babel-loader/*
