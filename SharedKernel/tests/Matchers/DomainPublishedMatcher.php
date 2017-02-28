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

use Kreta\SharedKernel\Domain\Model\AggregateRoot;
use PhpSpec\Exception\Example\FailureException;
use PhpSpec\Matcher\BasicMatcher;

/**
 * Usage:
 *    $this->shouldHavePublished(EventPublished::class);.
 */
class DomainPublishedMatcher extends BasicMatcher
{
    protected function matches($subject, array $arguments)
    {
        foreach ($subject->recordedEvents() as $event) {
            if ($event instanceof $arguments[0]) {
                return true;
            }
        }

        return false;
    }

    protected function getFailureException($name, $subject, array $arguments)
    {
        return new FailureException(
            sprintf(
                'Expected an event of type %s to be published. Found other %d event(s)',
                $arguments[0],
                count($subject->recordedEvents())
            )
        );
    }

    protected function getNegativeFailureException($name, $subject, array $arguments)
    {
        return new FailureException(
            sprintf(
                'Expected an event of type %s not to be published but it was.',
                $arguments[0]
            )
        );
    }

    public function supports($name, $subject, array $arguments)
    {
        return $name === 'havePublished' && $subject instanceof AggregateRoot;
    }
}
