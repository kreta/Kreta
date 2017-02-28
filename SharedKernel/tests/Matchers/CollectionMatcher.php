<?php

/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Kreta\SharedKernel\Tests\Matchers;

use Kreta\SharedKernel\Domain\Model\Collection;
use PhpSpec\Exception\Example\FailureException;
use PhpSpec\Matcher\BasicMatcher;

class CollectionMatcher extends BasicMatcher
{
    protected function matches($subject, array $arguments)
    {
        return $subject->toArray() === $arguments[0];
    }

    protected function getFailureException($name, $subject, array $arguments)
    {
        return new FailureException(
            'Expected to match Collection but it doesn`t'
        );
    }

    protected function getNegativeFailureException($name, $subject, array $arguments)
    {
        return new FailureException(
            'Expected not to match Collection but it does'
        );
    }

    public function supports($name, $subject, array $arguments)
    {
        return $name === 'returnCollection' && $subject instanceof Collection;
    }
}
