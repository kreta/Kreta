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

namespace Kreta\Notifier\Tests\Matchers;

use Kreta\Notifier\Domain\Model\Inbox\Notification\NotificationStatus;
use PhpSpec\Exception\Example\FailureException;
use PhpSpec\Matcher\BasicMatcher;

/**
 * Usage:
 *    $this->shouldBeAnUnreadNotificationStatus();.
 */
class UnreadNotificationStatusMatcher extends BasicMatcher
{
    protected function matches($subject, array $arguments) : bool
    {
        return $subject->status() === 'unread';
    }

    protected function getFailureException($name, $subject, array $arguments) : FailureException
    {
        return new FailureException(
            sprintf(
                'Expected a "unread" notification status. Found a "%s" notification status.',
                $subject->status()
            )
        );
    }

    protected function getNegativeFailureException($name, $subject, array $arguments) : FailureException
    {
        return $this->getFailureException($name, $subject, $arguments);
    }

    public function supports($name, $subject, array $arguments) : bool
    {
        return $name === 'beAnUnreadNotificationStatus' && $subject instanceof NotificationStatus;
    }
}
