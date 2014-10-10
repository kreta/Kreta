#!/bin/sh

# This file belongs to Kreta.
# The source code of application includes a LICENSE file
# with all information about license.
#
# @author benatespina <benatespina@gmail.com>
# @author gorkalaucirica <gorka.lauzirika@gmail.com>

echo "Loading everything about database and its data..."
php app/console doctrine:database:drop --force -e=dev
php app/console doctrine:database:create -e=dev
php app/console doctrine:schema:create -e=dev
php app/console doctrine:fixtures:load -e=dev --no-interaction
echo "The load is successfully completed"
