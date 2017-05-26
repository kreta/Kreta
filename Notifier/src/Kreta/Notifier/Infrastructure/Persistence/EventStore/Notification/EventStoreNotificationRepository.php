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

namespace Kreta\Notifier\Infrastructure\Persistence\EventStore\Notification;

use Kreta\Notifier\Domain\Model\Notification\Notification;
use Kreta\Notifier\Domain\Model\Notification\NotificationId;
use Kreta\Notifier\Domain\Model\Notification\NotificationRepository;
use Kreta\SharedKernel\Domain\Model\AggregateDoesNotExistException;
use Kreta\SharedKernel\Domain\Model\DomainEventCollection;
use Kreta\SharedKernel\Event\EventStore;
use Kreta\SharedKernel\Event\EventStream;
use Kreta\SharedKernel\Projection\Projector;

final class EventStoreNotificationRepository implements NotificationRepository
{
    private $eventStore;

    public function __construct(EventStore $eventStore)
    {
        $this->eventStore = $eventStore;
    }

    public function notificationOfId(NotificationId $id) : ?Notification
    {
        try {
            return Notification::reconstitute($this->eventStore->streamOfId($id));
        } catch (AggregateDoesNotExistException $exception) {
            return null;
        }
    }

    public function persist(Notification $notification) : void
    {
        $events = new DomainEventCollection($notification->recordedEvents());
        $eventStream = new EventStream($notification->id(), $events);

        $this->eventStore->appendTo($eventStream);
        $notification->clearEvents();

        Projector::instance()->project($events);
    }
}
