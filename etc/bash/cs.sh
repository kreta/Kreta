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

cd CompositeUi
node_modules/.bin/prettier src/**/*.js --list-different --single-quote --no-bracket-spacing --trailing-comma all
node_modules/.bin/eslint -c .eslintrc.js src/ --fix
node_modules/.bin/stylelint -c .stylelintrc.js src/scss/**/*.scss --syntax scss --fix
cd -
