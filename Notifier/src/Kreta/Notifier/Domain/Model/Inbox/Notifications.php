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

namespace Kreta\Notifier\Domain\Model\Inbox;

class Notifications implements \IteratorAggregate
{
    private $notifications;

    public function __construct(Notification ...$notifications)
    {
        $this->notifications = $notifications;
    }

    public function add(Notification $notification) : void
    {
        $this->notifications[] = $notification;
    }

    public function of(int $index) : Notification
    {
        if (!isset($this->notifications[$index])) {
            throw new NotificationDoesNotExist();
        }

        return $this->notifications[$index];
    }

    public function count() : int
    {
        return count($this->notifications);
    }

    public function getIterator() : \ArrayIterator
    {
        return new \ArrayIterator($this->notifications);
    }
}
