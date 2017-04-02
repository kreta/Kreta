#!/usr/bin/env bash

# This file is part of the Kreta package.
#
# (c) Beñat Espiña <benatespina@gmail.com>
# (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
#
# For the full copyright and license information, please view the LICENSE
# file that was distributed with this source code.

cd SharedKernel
composer run-script cs
cd -

cd IdentityAccess
composer run-script cs
cd -

cd TaskManager
composer run-script cs
cd -
