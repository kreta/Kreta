#!/usr/bin/env bash

cd SharedKernel
composer run-script cs
cd ..

cd IdentityAccess
composer run-script cs
cd ..

cd TaskManager
composer run-script cs
cd ..
