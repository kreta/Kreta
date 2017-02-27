#!/usr/bin/env bash

etc/bin/symfony-console kreta:task-manager:fixtures:users
sleep 2
etc/bin/symfony-console kreta:task-manager:fixtures:organizations
sleep 2
etc/bin/symfony-console kreta:task-manager:fixtures:projects
sleep 2
etc/bin/symfony-console kreta:task-manager:fixtures:tasks
