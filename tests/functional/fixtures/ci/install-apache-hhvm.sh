#!/bin/sh
# This file is part of the Kreta package.
#
# (c) Jon Torrado <jontorrado@gmail.com>
#
# For the full copyright and license information, please view the LICENSE
# file that was distributed with this source code.

# https://github.com/facebook/hhvm/wiki/fastcgi

sudo apt-get install apache2 libapache2-mod-fastcgi
sudo a2enmod rewrite actions fastcgi alias

# Configure apache virtual hosts
sudo cp -f tests/functional/fixtures/ci/travis-ci-apache-hhvm /etc/apache2/sites-available/default
sudo sed -e "s?%TRAVIS_BUILD_DIR%?$(pwd)?g" --in-place /etc/apache2/sites-available/default

# Rename needed .htaccess
sudo cp -f tests/functional/fixtures/web/.htaccess.dist tests/functional/fixtures/web/.htaccess

# Start HHVM as daemon
echo "starting HHVM"
hhvm -m daemon -vServer.Type=fastcgi -vServer.Port=9000 -vServer.FixPathInfo=true -vLog.Level=verbose -vLog.UseLogFile=true -vLog.File=/tmp/hhvm.log -vLog.AlwaysLogUnhandledExceptions=true -vPidFile=/tmp/hhvm.pid

# Restart Apache
sudo service apache2 restart
