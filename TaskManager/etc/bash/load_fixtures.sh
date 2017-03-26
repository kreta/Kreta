#!/usr/bin/env bash

etc/bin/symfony-console doctrine:fixtures:load --no-interaction --fixtures=src/Kreta/TaskManager/Infrastructure/Symfony/DoctrineDataFixtures
