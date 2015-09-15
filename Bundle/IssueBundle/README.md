# Kreta Issue Bundle
> Issue bundle of Kreta: modern project manager for software development.

[![Build Status](https://travis-ci.org/kreta/CoreBundle.svg?branch=master)](https://travis-ci.org/kreta/CoreBundle)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/kreta/CoreBundle/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/kreta/CoreBundle/?branch=master)
[![HHVM Status](http://hhvm.h4cc.de/badge/kreta/issue-bundle.svg)](http://hhvm.h4cc.de/package/kreta/issue-bundle)
[![Total Downloads](https://poser.pugx.org/kreta/issue-bundle/downloads)](https://packagist.org/packages/kreta/issue-bundle)
[![Latest Stable Version](https://poser.pugx.org/kreta/issue-bundle/v/stable.svg)](https://packagist.org/packages/kreta/issue-bundle)
[![Latest Unstable Version](https://poser.pugx.org/kreta/issue-bundle/v/unstable.svg)](https://packagist.org/packages/kreta/issue-bundle)

##Tests
This bundle is completely tested by **[PHPSpec][1], SpecBDD framework for PHP**.

Because you want to contribute or simply because you want to throw the tests, you have to type the following command
in your terminal.
```
$ bin/phpspec run -fpretty
```
>*Depends the location of the `bin` directory (sometimes in the root dir; sometimes in the `/vendor` dir) the way that
works every time is to use the absolute path of the binary `vendor/phpspec/phpspec/bin/phpspec`*

##Contributing
**The best practices of Kreta says that the recommend way to contribute to the project is using the
[development repository][2] but anyway, if the PR or issue is simple you can contribute directly in this
repository following this rules:**

This projects follows PHP coding standards, so pull requests need to execute the Fabien Potencier's [PHP-CS-Fixer][3]
and Marc Morera's [PHP-Formatter][4]. Furthermore, if the PR creates some not-PHP file remember that you have to put
the license header manually.
```
$ bin/php-cs-fixer fix
$ bin/php-cs-fixer fix --config-file .phpspec_cs

$ bin/php-formatter formatter:use:sort
$ bin/php-formatter formatter:header:fix
```

There is also a policy for contributing to this project. Pull requests must be explained step by step to make the
review process easy in order to accept and merge them. New methods or code improvements must come paired with
[PHPSpec][1] tests.

If you would like to contribute it is a good point to follow Symfony contribution standards, so please read the
[Contributing Code][5] in the project documentation. If you are submitting a pull request, please follow the guidelines
in the [Submitting a Patch][6] section and use the [Pull Request Template][7].

If you have any doubt or maybe you want to share some opinion, you can use our **Gitter chat**.
[![Gitter](https://badges.gitter.im/Join%20Chat.svg)](https://gitter.im/kreta/kreta?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge&utm_content=badge)

##Credits
Kreta Issue Bundle is created by:
>
**@benatespina** - [benatespina@gmail.com](mailto:benatespina@gmail.com)<br>
**@gorkalaucirica** - [gorka.lauzirika@gmail.com](mailto:gorka.lauzirika@gmail.com)

##Licensing Options
[![License](https://poser.pugx.org/kreta/issue-bundle/license.svg)](https://github.com/kreta/kreta/blob/master/LICENSE)

[1]: http://www.phpspec.net/
[2]: https://github.com/kreta/kreta-development
[3]: http://cs.sensiolabs.org/
[4]: https://github.com/mmoreram/php-formatter
[5]: http://symfony.com/doc/current/contributing/code/index.html
[6]: http://symfony.com/doc/current/contributing/code/patches.html#check-list
[7]: http://symfony.com/doc/current/contributing/code/patches.html#make-a-pull-request
