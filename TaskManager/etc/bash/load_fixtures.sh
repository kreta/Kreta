#!/usr/bin/env bash

TaskManager/etc/bin/symfony-console kreta:task-manager:fixtures:users
sleep 2
TaskManager/etc/bin/symfony-console kreta:task-manager:fixtures:organizations
sleep 2
TaskManager/etc/bin/symfony-console kreta:task-manager:fixtures:projects
