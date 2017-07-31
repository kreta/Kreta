<p align="center">
    <a href="https://kreta.io" target="_blank">
        <img width="250px" src="https://rawgithub.com/kreta/kreta/master/docs/_svg/logo.svg">
    </a>
</p>

<p align="center">
    <a href="https://travis-ci.org/kreta/Kreta">
        <img src="https://travis-ci.org/kreta/Kreta.svg?branch=master" alt="Build Status">
    </a>
    <a href="https://scrutinizer-ci.com/g/kreta/Kreta/?branch=master">
        <img src="https://scrutinizer-ci.com/g/kreta/Kreta/badges/quality-score.png?b=master" alt="Code Quality">
    </a>
    <a href="https://slackin-bcixopxwkb.now.sh">
        <img src="https://slackin-bcixopxwkb.now.sh/badge.svg" alt="Slack participants">
    </a>
    <a href="https://github.com/kreta/kreta/blob/master/LICENSE">
        <img src="https://poser.pugx.org/kreta/kreta/license.svg" alt="Licensing">
    </a>
</p>

## About Kreta
Kreta is an ecosystem based on microservices that following the [Domain-Driven Design][1] can provide a serious,
robust and testable project management platform written in modern [PHP][2]. In the other hand, the project keeps
constantly in mind the importance of a good user experience so, the good design and client-side logic is a must. For
that, Kreta uses "[React][3] with Redux" JavaScript stack.

We are committed to the [Continuous Delivery][10] philosophy so, all the code that is merged to the repository's
master branch is automatically deployed to production by [Travis](https://travis-ci.org/kreta/Kreta).
In this way you can visit the **[kreta.io][11]** and enjoy instantaneously with the last updates of the platform.

## Documentation
All the documentation is stored in the `/docs` folder.

[Show me the docs!](docs/index.md)

## Contributing
Kreta follows PHP, Sass and JavaScript coding standards, so pull requests need to pass the [PHP-CS-Fixer][5],
[Stylelint][6] and [ESLint][7]. Furthermore, if the PR creates some non-PHP file, remember that you have to put the
license header manually. In order to simplify the CS process we provide a simple bash script that wraps all the
commands related.
```bash
$ sh etc/bash/cs.sh
```

There is also a policy for contributing to this project. Pull requests must be explained step by step to make the
review process easy in order to accept and merge them. New methods or code improvements must come paired with
tests. We are using [PhpSpec][8] for PHP unit testing, [PHPUnit][12] for PHP integration tests and [Jest][9] for
JavaScript code.

## Credits
Kreta is created by:
>
**@benatespina** - [benatespina@gmail.com](mailto:benatespina@gmail.com)<br>
**@gorkalaucirica** - [gorka.lauzirika@gmail.com](mailto:gorka.lauzirika@gmail.com)

## License
The Kreta project is open-sourced software licensed under the [MIT license](https://raw.githubusercontent.com/kreta/kreta/master/LICENSE).

[1]: https://en.wikipedia.org/wiki/Domain-driven_design
[2]: http://php.net/
[3]: https://facebook.github.io/react/
[4]: http://demo.kreta.io/
[5]: http://cs.sensiolabs.org/
[6]: http://stylelint.io/
[7]: http://eslint.org/
[8]: http://www.phpspec.net/
[9]: https://facebook.github.io/jest/
[10]: https://en.wikipedia.org/wiki/Continuous_delivery
[11]: https://kreta.io/
[12]: https://phpunit.de/
