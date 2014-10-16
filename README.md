# Kreta
> Modern task manager for software development.

[![Build Status](https://travis-ci.org/kreta-io/kreta.svg?branch=master)](https://travis-ci.org/kreta-io/kreta)
[![Coverage Status](https://img.shields.io/coveralls/kreta-io/kreta.svg)](https://coveralls.io/r/kreta-io/kreta)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/kreta-io/kreta/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/kreta-io/kreta/?branch=master)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/c744caca-06bb-4b7f-9e0d-96282f4e8469/mini.png)](https://insight.sensiolabs.com/projects/c744caca-06bb-4b7f-9e0d-96282f4e8469)
[![HHVM Status](http://hhvm.h4cc.de/badge/kreta-io/kreta.svg)](http://hhvm.h4cc.de/package/kreta-io/kreta)


Prerequisites
-------------
To start to use this project, you have a **Vagrant** virtual machine in the root directory that provides a completely
functional environment for running *Kreta*. This Vagrant that is imported as submodule is maintained by
[benatespina](mailto:benatespina@gmail.com) in this [repository](https://github.com/benatespina/default-vagrant) so, we are pretty sure that you won`t any problems to use it; however, if you have any kind of question or doubt, do not
hesitate to contact us.

* Install [Vagrant](http://docs.vagrantup.com/v2/installation/index.html) on your system, which in turn requires
[RubyGems](https://rubygems.org/pages/download) and [VirtualBox](https://www.virtualbox.org/wiki/Downloads).

*NOTE: If you are on Windows, I would recommend [RubyInstaller](http://rubyinstaller.org/) for installing Ruby and any
ssh client as [PuTTY](http://www.chiark.greenend.org.uk/~sgtatham/putty/download.html) for log into your Vagrant box.*

* This box has some dependencies so you must install
**[vagrant-hostsupdater](https://github.com/cogitatio/vagrant-hostsupdater)** plugin for Vagrant, which adds an entry
to your `/etc/hosts` file on the host system and **[vagrant-vbguest](https://github.com/dotless-de/vagrant-vbguest)**
 which automatically installs the host's VirtualBox Guest Additions on the guest system.
```
vagrant plugin install vagrant-hostsupdater
vagrant plugin install vagrant-vbguest
```

Getting started
---------------

The recommended way to clone this project is using the following command in order to add *git submodules* too:

    git clone --recursive https://github.com/kreta/kreta.git kreta

Then, inside `/vagrant` directory you have to copy the `parameters.yml.dist` in the same directory but without
`.dist` extension, modifying the values with your favorite preferences. This is the `parameters.yml` file that we recommend:

```
$vhost                  = "kreta"
$domain                 = "localhost"
$vhostpath              = "/var/www"

$ip                     = "192.168.10.42"
$port                   = 8080
$use_nfs                = true
$base_box               = "precise64"

$database_rootpassword  = "app"             # It must be the same that database_user variable from parameters.yml file
$database_user          = "kreta-user"
$database_password      = "123"             # It must be the same that database_password variable from parameters.yml file
$database_name          = "kreta"           # It must be the same that database_name variable from parameters.yml file

$database               = "mysql"

$cpu                    = "1"
$memory                 = "512"

######## ENVIRONMENTS ########
$symfony = true
```

In the next step, you have to build the *Vagrant* machine and then, you have to connect via **ssh** to the VM with the
following commands:

    cd /vagrant
    vagrant up
    vagran ssh

Finally, you have to load everything related to **database** (create database if it is not exist, create schema and load some
fixtures). The recommended way to do all of these steps is executing the following command.

    sh scripts/update_doctrine_dev.sh

And that's all! Now, if you go to the `http://kreta.localhost` url, you will see your site up and running

Contributing
------------

This projects follows PHP coding standards, so pull requests must pass PHP Code Sniffer and PHP Mess Detector
checks. In the root directory of this project you have the **custom rulesets** ([ruleset.xml]() for PHPCS and
[phpmd.xml]() for PHPMD).

There is also a policy for contributing to this project. Pull requests must
be explained step by step to make the review process easy in order to
accept and merge them. New methods or code improvements must come paired with [PHPSpec][1] tests.

If you would like to contribute it is a good point to follow Symfony contribution standards,
so please read the [Contributing Code][2] in the project
documentation. If you are submitting a pull request, please follow the guidelines
in the [Submitting a Patch][3] section and use the [Pull Request Template][4].

[1]: http://www.phpspec.net/
[2]: http://symfony.com/doc/current/contributing/code/index.html
[3]: http://symfony.com/doc/current/contributing/code/patches.html#check-list
[4]: http://symfony.com/doc/current/contributing/code/patches.html#make-a-pull-request

Credits
-------
Kreta is created by:
>
**@benatespina** - [benatespina@gmail.com](mailto:benatespina@gmail.com)<br/>
**@gorkalaucirica** - [gorka.lauzirika@gmail.com](mailto:gorka.lauzirika@gmail.com)

Licensing Options
-----------------
Released under MIT license. See [LICENSE.md](https://github.com/kreta/kreta/blob/master/LICENSE.md) file for more information.
