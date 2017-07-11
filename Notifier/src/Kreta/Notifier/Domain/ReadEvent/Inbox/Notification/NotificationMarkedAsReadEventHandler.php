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

namespace Kreta\Notifier\Domain\ReadEvent\Inbox\Notification;

use Kreta\Notifier\Domain\Model\Inbox\Notification\NotificationMarkedAsRead;
use Kreta\Notifier\Domain\ReadModel\Inbox\Notification\NotificationView;
use Kreta\SharedKernel\Domain\Model\DomainEvent;
use Kreta\SharedKernel\Domain\ReadEvent\EventHandler;

class NotificationMarkedAsReadEventHandler implements EventHandler
{
    private $view;

    public function __construct(NotificationView $view)
    {
        $this->view = $view;
    }

    public function isSubscribeTo() : string
    {
        return NotificationMarkedAsRead::class;
    }

    public function handle(DomainEvent $event) : void
    {
        $notification = $this->view->notificationOfId($event->notificationId());

        $notification->status = $event->status()->status();
        $notification->readOn = $event->occurredOn()->getTimestamp();

        $this->view->save($notification);
    }
}
