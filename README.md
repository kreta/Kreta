<p align="center">
    <a href="https://kreta.io" target="_blank">
        <img src="https://rawgithub.com/kreta/kreta/master/docs/_svg/logo.svg">
    </a>
</p>

> Modern project management solution

[![Build Status](https://travis-ci.org/kreta/kreta.svg?branch=master)](https://travis-ci.org/kreta/kreta)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/kreta/kreta/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/kreta/kreta/?branch=master)

Kreta is an ecosystem based on microservices that following the **[Domain-Driven Design][1]** can provide a serious,
robust and testable project management platform written in **[PHP7][2]**. In the other hand, the project keeps
constantly in mind the importance of a good user experience so, the good design and client-side logic is a must. For
that, Kreta uses "**[React][3]** with Redux" JavaScript stack.

If you want to test the project without any installation, you can play with a **public demo site in
[demo.kreta.io][4]**.
> Feel free to change anything you can, it has a cron that reloads all the dummy content everyday :)

##Documentation
All the documentation is stored in the `docs` folder.

[Show me the docs!](docs/index.md)

##Contributing
Kreta follows PHP, Sass and JavaScript coding standards, so pull requests need to pass the [PHP-CS-Fixer][5],
[Stylelint][6] and [ESLint][7]. Furthermore, if the PR creates some non-PHP file, remember that you have to put the
license header manually. In order to simplify the CS process we provide a simple bash script that wraps all the
commands related.
```bash
$ sh etc/bash/cs.sh
```

There is also a policy for contributing to this project. Pull requests must be explained step by step to make the
review process easy in order to accept and merge them. New methods or code improvements must come paired with
tests. We are using [PhpSpec][8] for PHP unit testing and [Jest][9] for JavaScript code.

If you have any doubt or maybe you want to share some opinion, you can use our **Gitter chat**.

[![Gitter](https://badges.gitter.im/Join%20Chat.svg)](https://gitter.im/kreta/kreta?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge&utm_content=badge)

##Credits
Kreta is created by:
>
**@benatespina** - [benatespina@gmail.com](mailto:benatespina@gmail.com)<br>
**@gorkalaucirica** - [gorka.lauzirika@gmail.com](mailto:gorka.lauzirika@gmail.com)

##Licensing Options
[![License](https://poser.pugx.org/kreta/kreta/license.svg)](https://github.com/kreta/kreta/blob/master/LICENSE)

[1]: https://en.wikipedia.org/wiki/Domain-driven_design
[2]: http://php.net/
[3]: https://facebook.github.io/react/
[4]: http://demo.kreta.io/
[5]: http://cs.sensiolabs.org/
[6]: http://stylelint.io/
[7]: http://eslint.org/
[8]: http://www.phpspec.net/
[9]: https://facebook.github.io/jest/
