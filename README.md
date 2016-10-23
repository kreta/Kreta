<p align="center">
    <a href="https://kreta.io" target="_blank">
        <img src="https://rawgithub.com/kreta/kreta/master/docs/_svg/logo.svg">
    </a>
</p>

<p align="center">
  <a href="https://insight.sensiolabs.com/projects/c744caca-06bb-4b7f-9e0d-96282f4e8469"><img src="https://insight.sensiolabs.com/projects/c744caca-06bb-4b7f-9e0d-96282f4e8469/mini.png" alt="SensioLabsInsight"></a>
  <a href="https://travis-ci.org/kreta/kreta"><img src="https://travis-ci.org/kreta/kreta.svg?branch=master" alt="Build Status"></a>
  <a href="https://scrutinizer-ci.com/g/kreta/kreta/?branch=master"><img src="https://scrutinizer-ci.com/g/kreta/kreta/badges/quality-score.png?b=master" alt="Scrutinizer Code Quality"></a>
  <a href="https://packagist.org/packages/kreta/kreta"><img src="https://poser.pugx.org/kreta/kreta/downloads" alt="Total Downloads"></a>
  <a href="https://packagist.org/packages/kreta/kreta"><img src="https://poser.pugx.org/kreta/kreta/v/stable.svg" alt="Latest Stable Version"></a>
  <a href="https://packagist.org/packages/kreta/kreta"><img src="https://poser.pugx.org/kreta/kreta/v/unstable.svg" alt="Latest Unstable Version"></a>
</p>

> Modern project management solution

If you want to test the project without any installation, you can play with a **public demo site in
[demo.kreta.io][15]**.
> Feel free to change anything you can, it has a cron that reloads all the dummy content everyday :)

##Documentation
All the documentation is stored in the `docs` folder.

[Show me the docs!](docs/index.md)

##Contributing
This project follows PHP coding standards, so pull requests need to execute the Fabien Potencier's [PHP-CS-Fixer][4].
Furthermore, if the PR creates some not-PHP file remember that you have to put the license header manually.
In order to simplify we provide a Composer script that wraps all the commands related with this process.
```bash
$ composer run-script cs
```

There is also a policy for contributing to this project. Pull requests must be explained step by step to make the
review process easy in order to accept and merge them. New methods or code improvements must come paired with
[PHPSpec][3] tests.

If you would like to contribute it is a good point to follow Symfony contribution standards, so please read the
[Contributing Code][6] in the project documentation. If you are submitting a pull request, please follow the guidelines
in the [Submitting a Patch][7] section and use the [Pull Request Template][8].

If you have any doubt or maybe you want to share some opinion, you can use our **Gitter chat**.

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
[6]: http://symfony.com/doc/current/contributing/code/index.html
[7]: http://symfony.com/doc/current/contributing/code/patches.html#check-list
[8]: http://symfony.com/doc/current/contributing/code/patches.html#make-a-pull-request
[9]: http://symfony.com/
[10]: https://facebook.github.io/react/
[11]: http://redux.js.org/
[12]: http://sass-lang.com/
[13]: http://docs.behat.org/en/latest/
[14]: https://facebook.github.io/jest/
[15]: http://demo.kreta.io/
[16]: https://en.bem.info/
[17]: http://www.php.net/
