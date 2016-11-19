#!/usr/bin/env bash

etc/bin/task-manager-console kreta:task-manager:fixtures:users
sleep 2
etc/bin/task-manager-console kreta:task-manager:fixtures:organizations
sleep 2
etc/bin/task-manager-console kreta:task-manager:fixtures:projects
