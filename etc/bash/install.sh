#!/usr/bin/env bash

# This file is part of the Kreta package.
#
# (c) Beñat Espiña <benatespina@gmail.com>
# (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
#
# For the full copyright and license information, please view the LICENSE
# file that was distributed with this source code.

cd SharedKernel
composer install
cd -

cd IdentityAccess
composer install
sh etc/bash/generate_ssh_keys.sh
sh etc/bash/load_database.sh
cd -

cd TaskManager
composer install
sh etc/bash/load_database.sh
cd -

cd CompositeUi
yarn install
sh etc/bash/update_graph_schema.sh
cd -
