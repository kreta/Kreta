# Kreta
> Modern project manager for software development.

[![Build Status](https://travis-ci.org/kreta-io/kreta.svg?branch=master)](https://travis-ci.org/kreta-io/kreta)
[![Coverage Status](https://img.shields.io/coveralls/kreta-io/kreta.svg)](https://coveralls.io/r/kreta-io/kreta)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/kreta-io/kreta/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/kreta-io/kreta/?branch=master)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/c744caca-06bb-4b7f-9e0d-96282f4e8469/mini.png)](https://insight.sensiolabs.com/projects/c744caca-06bb-4b7f-9e0d-96282f4e8469)
[![HHVM Status](http://hhvm.h4cc.de/badge/kreta/kreta.svg)](http://hhvm.h4cc.de/package/kreta/kreta)
[![Total Downloads](https://poser.pugx.org/kreta/kreta/downloads)](https://packagist.org/packages/kreta/kreta)

[![Latest Stable Version](https://poser.pugx.org/kreta/kreta/v/stable.svg)](https://packagist.org/packages/kreta/kreta)
[![Latest Unstable Version](https://poser.pugx.org/kreta/kreta/v/unstable.svg)](https://packagist.org/packages/kreta/kreta)

Firstly, you need to download Kreta's dependencies using **[Composer][6]**.

    $ composer install

Tests
-----
This project is completely tested by full-stack **BDD methodology**.

For testing [PHPSpec][1] and [Behat][5] are used.

To run [PHPSpec][1] type the following

    $ bin/phpspec run -fpretty

>This repository is not a standalone and usable application so, you cannot execute Behat scenarios; to do this you
>should use the [development repository][7] of Kreta that is a
>complete Symfony application.

Contributing
------------
**The best practices of Kreta says that the recommend way to contribute to the project is using the
[development repository][7] but anyway, if the PR or issue is simple you can contribute directly in this
repository following this rules:**

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

If you have any doubt or maybe you want to share some opinion, you can use our **Gitter chat**.
[![Gitter](https://badges.gitter.im/Join%20Chat.svg)](https://gitter.im/kreta-io/kreta?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge&utm_content=badge)

[1]: http://www.phpspec.net/
[2]: http://symfony.com/doc/current/contributing/code/index.html
[3]: http://symfony.com/doc/current/contributing/code/patches.html#check-list
[4]: http://symfony.com/doc/current/contributing/code/patches.html#make-a-pull-request
[5]: http://behat.org
[6]: http://getcomposer.org/download
[7]: https://github.com/kreta-io/kreta-development

Credits
-------
Kreta is created by:
>
**@benatespina** - [benatespina@gmail.com](mailto:benatespina@gmail.com)<br/>
**@gorkalaucirica** - [gorka.lauzirika@gmail.com](mailto:gorka.lauzirika@gmail.com)

Licensing Options
-----------------
[![License](https://poser.pugx.org/kreta/kreta/license.svg)](https://github.com/kreta-io/kreta/blob/master/LICENSE)
