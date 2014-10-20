#!/bin/sh

# This file belongs to Kreta.
# The source code of application includes a LICENSE file
# with all information about license.
#
# @author benatespina <benatespina@gmail.com>
# @author gorkalaucirica <gorka.lauzirika@gmail.com>

echo "Sass-convert is beautifying the Sass files..."
sh "scripts/hooks/pre-commits/sass-convert.sh"

echo "Executing unit-tests => specs..."
sh "scripts/hooks/pre-commits/phpspec.sh"
