#!/usr/bin/env bash

cd ../TaskManager
etc/bin/symfony-console graph:dump-schema --file=../CompositeUi/schema.json
cd -
