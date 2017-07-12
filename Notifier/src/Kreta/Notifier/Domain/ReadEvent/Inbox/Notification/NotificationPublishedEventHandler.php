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

use Kreta\Notifier\Domain\Model\Inbox\Notification\NotificationPublished;
use Kreta\Notifier\Domain\ReadModel\Inbox\Notification\Notification;
use Kreta\Notifier\Domain\ReadModel\Inbox\Notification\NotificationView;
use Kreta\SharedKernel\Domain\Model\DomainEvent;
use Kreta\SharedKernel\Domain\ReadEvent\EventHandler;

class NotificationPublishedEventHandler implements EventHandler
{
    private $view;

    public function __construct(NotificationView $view)
    {
        $this->view = $view;
    }

    public function isSubscribeTo() : string
    {
        return NotificationPublished::class;
    }

    public function handle(DomainEvent $event) : void
    {
        $notification = new Notification(
            $event->notificationId()->id(),
            $event->userId()->id(),
            $event->type()->type(),
            $event->body()->body(),
            $event->occurredOn()->getTimestamp(),
            $event->status()->status()
        );

        $this->view->save($notification);
    }
}
