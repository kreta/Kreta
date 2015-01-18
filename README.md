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
To start to use this project, we recommend using a **Vagrant** virtual machine located in the root directory that provides a completely functional environment for running *Kreta*. This Vagrant that is imported as submodule is maintained by [benatespina](https://github.com/benatespina) in this [repository](https://github.com/benatespina/default-vagrant) so, we are pretty sure that you won`t any problems to use it; however, if you have any kind of question or doubt, do not hesitate to contact us.

To make it work, first of all you need to install [Vagrant](http://docs.vagrantup.com/v2/installation/index.html) on your system, which in turn requires [RubyGems](https://rubygems.org/pages/download) and [VirtualBox](https://www.virtualbox.org/wiki/Downloads).

>  If you are on Windows, we recommend [RubyInstaller](http://rubyinstaller.org/) to install Ruby and any ssh client as [PuTTY](http://www.chiark.greenend.org.uk/~sgtatham/putty/download.html) for log into your Vagrant box.

This box has some dependencies so you must install [vagrant-hostsupdater](https://github.com/cogitatio/vagrant-hostsupdater) plugin for Vagrant, which adds an entry to your `/etc/hosts` file on the host system and [vagrant-vbguest](https://github.com/dotless-de/vagrant-vbguest) which automatically installs the host's VirtualBox Guest Additions on the guest system.
```
$ vagrant plugin install vagrant-hostsupdater
$ vagrant plugin install vagrant-vbguest
```

Getting started
---------------

The recommended way to clone this project is using the following command in order to add *git submodules* too:

    $ git clone --recursive https://github.com/kreta/kreta.git kreta

Then, inside `/vagrant` directory you have to copy the `parameters.yml.dist` in the same directory to `parameters.yml`, modifying the values with your favorite preferences. This is what we recommend:

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
        user:         kretaUser     
        password:     123           
        name:         kreta

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

> NOTE: sometimes when you type `vagrant up` of provisioned box, the `/dev/shm/symfony/cache` and `/dev/shm/symfony/logs`
folders are disappeared; to solve this problem you have to execute `sh scripts/clear_cache.sh`

Once, you are inside the *Vagrant* box you need to download Kreta's dependencies using **[Composer][6]**.

    $ composer install

After that, you have to load everything related to **database** (create database if it is not exist, create schema and load some fixtures). The fastest way is executing the following command.

    $ sh scripts/update_doctrine_dev.sh

Finally, you have to dump the assets files:

    $ php app/console assetic:dump

And that's all! Now, if you access `http://kreta.localhost`, you will see your site up and running.

Tests
-----
This project is completely tested by full-stack **BDD methodology**.

For testing [PHPSpec][1] and [Behat][5] are used.

To run [PHPSpec][1] type the following

    $ bin/phpspec run -fpretty

To run [Behat][5] tests run the following

    $ sh scripts/pre_behat.sh
    $ bin/behat

If you want to check the **code-coverage** of previous tests, PHPSpec generates them by default. To activate the Behat code-coverage you have to uncomment the lines of `behat.yml` file.


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
