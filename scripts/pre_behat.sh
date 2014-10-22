#!/bin/sh

# This file belongs to Kreta.
# The source code of application includes a LICENSE file
# with all information about license.
#
# @author benatespina <benatespina@gmail.com>
# @author gorkalaucirica <gorka.lauzirika@gmail.com>

php app/console doctrine:database:drop --force -e=test
php app/console doctrine:database:create -e=test
php app/console doctrine:schema:create -e=test
echo "The database is successfully created"
