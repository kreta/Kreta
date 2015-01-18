# Kreta
> Modern project manager for software development.

[![Build Status](https://travis-ci.org/kreta-io/kreta.svg?branch=master)](https://travis-ci.org/kreta-io/kreta)
[![Coverage Status](https://img.shields.io/coveralls/kreta-io/kreta.svg)](https://coveralls.io/r/kreta-io/kreta)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/kreta-io/kreta/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/kreta-io/kreta/?branch=master)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/c744caca-06bb-4b7f-9e0d-96282f4e8469/mini.png)](https://insight.sensiolabs.com/projects/c744caca-06bb-4b7f-9e0d-96282f4e8469)
[![HHVM Status](http://hhvm.h4cc.de/badge/kreta/kreta.svg)](http://hhvm.h4cc.de/package/kreta/kreta)
[![Total Downloads](https://poser.pugx.org/kreta/kreta/downloads.svg)](https://packagist.org/packages/kreta/kreta)

[![Latest Stable Version](https://poser.pugx.org/kreta/kreta/v/stable.svg)](https://packagist.org/packages/kreta/kreta)
[![Latest Unstable Version](https://poser.pugx.org/kreta/kreta/v/unstable.svg)](https://packagist.org/packages/kreta/kreta)

Prerequisites
-------------
To start to use this project, you have a **Vagrant** virtual machine in the root directory that provides a completely
functional environment for running *Kreta*. This Vagrant that is imported as submodule is maintained by
[benatespina](mailto:benatespina@gmail.com) in this [repository](https://github.com/benatespina/default-vagrant) so, we
are pretty sure that you won`t any problems to use it; however, if you have any kind of question or doubt, do not
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
$ vagrant plugin install vagrant-hostsupdater
$ vagrant plugin install vagrant-vbguest
```

Getting started
---------------

The recommended way to clone this project is using the following command in order to add *git submodules* too:

    $ git clone --recursive https://github.com/kreta/kreta.git kreta

Then, inside `/vagrant` directory you have to copy the `parameters.yml.dist` in the same directory but without
`.dist` extension, modifying the values with your favorite preferences. This is the `parameters.yml` file that we recommend:

```
virtual_machine:
    vhost:      kreta
    domain:     localhost
    vhostpath:  /var/www
    ip:         192.168.10.42
    port:       8080
    use_nfs:    true
    box:        precise64
    cpu:        1
    memory:     512

database:
    mysql:
        rootpassword: app
        user:         kretaUser     # It must be the same that database_user variable from app/config/parameters.yml
        password:     123           # It must be the same that database_password variable from app/config/parameters.yml
        name:         kreta         # It must be the same that database_name variable from app/config/parameters.yml

environments:
    ruby:
        sass: latest
        compass: 0.12.6
    symfony: true
```

In the next step, you have to build the *Vagrant* machine and then, you have to connect via **ssh** to the VM with the
following commands:

    $ cd /vagrant
    $ vagrant up
    $ vagran ssh

*NOTE: sometimes when you type `vagrant up` of provisioned box, the `/dev/shm/symfony/cache` and `/dev/shm/symfony/logs`
folders are disappeared; to solve this problem you have to execute `sh scripts/clear_cache.sh`*

Once, you are inside the *Vagrant* box you need to download Kreta's dependencies using **[Composer][6]**.

    $ composer install

After that, you have to load everything related to **database** (create database if it is not exist, create schema and
load some fixtures). The fastest way to do all of these steps is executing the following command.

    $ sh scripts/update_doctrine_dev.sh

Finally, you have to dump the `.scss` and `.js` files for a better front-end experience with the command below:

    $ php app/console assetic:dump

And that's all! Now, if you access `http://kreta.localhost`, you will see your site up and running.

Tests
-----
This project is completely tested by full-stack **BDD methodology**.

Firstly, is completely tested by **[PHPSpec][1], SpecBDD framework for PHP**.

Because you want to contribute or simply because you want to throw the tests, you have to type the following command
in your terminal.

    $ phpspec run -fpretty

*Depends the location of the `bin` directory (sometimes in the root dir; sometimes in the `/vendor` dir) the way that
works every time is to use the absolute path of the binary `vendor/phpspec/phpspec/bin/phpspec`*

Furthermore, **[Behat][5], StoryBDD framework for PHP** has *scenarios* that it tests the project in functional mode.
As mentioned above, if you want to throw the test, you have to create the test environment database with its schema and
then, type the following command in your terminal.

    $ sh scripts/pre_behat.sh
    $ behat

*Depends the location of the `bin` directory (sometimes in the root dir; sometimes in the `/vendor` dir) the way that
works every time is to use the absolute path of the binary `vendor/behat/behat/bin/behat`*

If you want to check the **code-coverage** of previous tests, PHPSpec generates it by default, but to activate the Behat
code-coverage you have to uncomment the lines of `behat.yml` file.

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
[5]: http://behat.org
[6]: http://getcomposer.org/download

Credits
-------
Kreta is created by:
>
**@benatespina** - [benatespina@gmail.com](mailto:benatespina@gmail.com)<br/>
**@gorkalaucirica** - [gorka.lauzirika@gmail.com](mailto:gorka.lauzirika@gmail.com)

Licensing Options
-----------------
[![License](https://poser.pugx.org/kreta/kreta/license.svg)](https://github.com/kreta-io/kreta/blob/master/LICENSE.md)
