#!/usr/bin/env bash

cd SharedKernel
vendor/bin/phpspec run
cd ..

cd IdentityAccess
vendor/bin/phpspec run
cd ..

cd TaskManager
vendor/bin/phpspec run
cd ..

cd CompositeUi
yarn test
cd ..
