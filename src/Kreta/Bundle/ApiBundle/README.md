# Kreta Api Bundle
> Api bundle of Kreta: modern project manager for software development.

[![Build Status](https://travis-ci.org/kreta-io/ApiBundle.svg?branch=master)](https://travis-ci.org/kreta-io/ApiBundle)
[![Coverage Status](https://img.shields.io/coveralls/kreta-io/ApiBundle.svg)](https://coveralls.io/r/kreta-io/ApiBundle)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/kreta-io/ApiBundle/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/kreta-io/ApiBundle/?branch=master)
[![HHVM Status](http://hhvm.h4cc.de/badge/kreta/api-bundle.svg)](http://hhvm.h4cc.de/package/kreta/api-bundle)

[![Latest Stable Version](https://poser.pugx.org/kreta/api-bundle/v/stable.svg)](https://packagist.org/packages/kreta/api-bundle)
[![Latest Unstable Version](https://poser.pugx.org/kreta/api-bundle/v/unstable.svg)](https://packagist.org/packages/kreta/api-bundle)
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
[![Total Downloads](https://poser.pugx.org/kreta/api-bundle/downloads.svg)](https://packagist.org/packages/kreta/api-bundle)
[![Monthly Downloads](https://poser.pugx.org/kreta/api-bundle/d/monthly.png)](https://packagist.org/packages/kreta/api-bundle)
[![Daily Downloads](https://poser.pugx.org/kreta/api-bundle/d/daily.png)](https://packagist.org/packages/kreta/api-bundle)

Tests
-----

This bundle is completely tested by **[PHPSpec][1], SpecBDD framework for PHP**.

Because you want to contribute or simply because you want to throw the tests, you have to type the following command
in your terminal.

    phpspec run -fpretty

*Depends the location of the `bin` directory (sometimes in the root dir; sometimes in the `/vendor` dir) the way that
works every time is to use the absolute path of the binary `vendor/phpspec/phpspec/bin/phpspec`*


Contributing
------------

This bundle follows PHP coding standards, so pull requests must pass PHP Code Sniffer and PHP Mess Detector
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
Kreta Api Bundle is created by:
>
**@benatespina** - [benatespina@gmail.com](mailto:benatespina@gmail.com)<br/>
**@gorkalaucirica** - [gorka.lauzirika@gmail.com](mailto:gorka.lauzirika@gmail.com)

Licensing Options
-----------------
[![License](https://poser.pugx.org/kreta/api-bundle/license.svg)](https://github.com/kreta-io/kreta/blob/master/LICENSE.md)
