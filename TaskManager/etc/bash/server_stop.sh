#!/usr/bin/env bash

export SYMFONY_ENV=dev
etc/bin/symfony-console server:stop 127.0.0.1:8001
