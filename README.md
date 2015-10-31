#Kreta
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/c744caca-06bb-4b7f-9e0d-96282f4e8469/mini.png)](https://insight.sensiolabs.com/projects/c744caca-06bb-4b7f-9e0d-96282f4e8469)
[![Build Status](https://travis-ci.org/kreta/kreta.svg?branch=master)](https://travis-ci.org/kreta/kreta)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/kreta/kreta/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/kreta/kreta/?branch=master)
[![Total Downloads](https://poser.pugx.org/kreta/kreta/downloads)](https://packagist.org/packages/kreta/kreta)
[![Latest Stable Version](https://poser.pugx.org/kreta/kreta/v/stable.svg)](https://packagist.org/packages/kreta/kreta)
[![Latest Unstable Version](https://poser.pugx.org/kreta/kreta/v/unstable.svg)](https://packagist.org/packages/kreta/kreta)

Kreta is a set of components and bundles focused on **project management** for **PHP**, based on the
**[Symfony][9]** framework. It has a very rich front-end that it is developed with the
**[Backbone.js][10]** + **[React.js][11]** stuff and designed with **[Sass][12]**.

Also, Kreta provides an **[standard edition][1]** that is a fully functional web application that shows in an easy
way all the possibilities of the platform.

Kreta is developed following the decoupling and reuse principles so, it provides a set of plugins that are available
in **[kreta-plugins][2]**.

##Tests
This repository is completely tested following *BDD* methodology with **[PHPSpec][3]** and **[Behat][13]**,
SpecBDD and StoryBDD frameworks for PHP. Also, the JavaScript code is tested following the *Swallow Rendering*
methodology with **[Jest][14]**.

[![Coverage Status](https://img.shields.io/coveralls/kreta/kreta.svg)](https://coveralls.io/r/kreta/kreta)
##Contributing
This project follows PHP coding standards, so pull requests need to execute the Fabien Potencier's [PHP-CS-Fixer][4]
and Marc Morera's [PHP-Formatter][5]. Furthermore, if the PR creates some not-PHP file remember that you have to put
the license header manually. In order to simplify we provide a Composer script that wraps all the commands related with
this process.
```bash
$ composer run-script cs
```

There is also a policy for contributing to this project. Pull requests must be explained step by step to make the
review process easy in order to accept and merge them. New methods or code improvements must come paired with
[PHPSpec][3] tests.

If you would like to contribute it is a good point to follow Symfony contribution standards, so please read the
[Contributing Code][6] in the project documentation. If you are submitting a pull request, please follow the guidelines
in the [Submitting a Patch][7] section and use the [Pull Request Template][8].

If you have any doubt or maybe you want to share some opinion, you can use our **Gitter chat**.<br>
[![Gitter](https://badges.gitter.im/Join%20Chat.svg)](https://gitter.im/kreta/kreta?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge&utm_content=badge)

##Credits
Kreta is created by:
>
**@benatespina** - [benatespina@gmail.com](mailto:benatespina@gmail.com)<br>
**@gorkalaucirica** - [gorka.lauzirika@gmail.com](mailto:gorka.lauzirika@gmail.com)

##Licensing Options
[![License](https://poser.pugx.org/kreta/kreta/license.svg)](https://github.com/kreta/kreta/blob/master/LICENSE)

[1]: https://github.com/kreta/kreta-standard
[2]: https://github.com/kreta-plugins
[3]: http://www.phpspec.net/
[4]: http://cs.sensiolabs.org/
[5]: https://github.com/mmoreram/php-formatter
[6]: http://symfony.com/doc/current/contributing/code/index.html
[7]: http://symfony.com/doc/current/contributing/code/patches.html#check-list
[8]: http://symfony.com/doc/current/contributing/code/patches.html#make-a-pull-request
[9]: http://symfony.com/
[10]: http://backbonejs.org/
[11]: https://facebook.github.io/react/
[12]: http://sass-lang.com/
[13]: http://docs.behat.org/en/latest/
[14]:https://facebook.github.io/jest/
