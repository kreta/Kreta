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

namespace Kreta\Notifier\Infrastructure\Domain\Model\Inbox\Notification;

use Kreta\Notifier\Domain\Model\Inbox\Notification\Notification;
use Kreta\Notifier\Domain\Model\Inbox\Notification\NotificationDoesNotExist;
use Kreta\Notifier\Domain\Model\Inbox\Notification\NotificationId;
use Kreta\Notifier\Domain\Model\Inbox\Notification\NotificationRepository;
use Kreta\SharedKernel\Domain\Model\AggregateDoesNotExistException;
use Kreta\SharedKernel\Domain\Model\DomainEventCollection;
use Kreta\SharedKernel\Event\EventStore;
use Kreta\SharedKernel\Event\Stream;
use Kreta\SharedKernel\Event\StreamName;
use Kreta\SharedKernel\Projection\Projector;

final class EventStoreNotificationRepository implements NotificationRepository
{
    private const NAME = 'notification';

    private $eventStore;

    public function __construct(EventStore $eventStore)
    {
        $this->eventStore = $eventStore;
    }

    public function get(NotificationId $id) : Notification
    {
        try {
            return Notification::reconstitute(
                $this->eventStore->streamOfName(
                    new StreamName(
                        $id,
                        self::NAME
                    )
                )
            );
        } catch (AggregateDoesNotExistException $exception) {
            throw new NotificationDoesNotExist();
        }
    }

    public function save(Notification $notification) : void
    {
        $events = new DomainEventCollection($notification->recordedEvents());

        $eventStream = new Stream(
            new StreamName(
                $notification->id(),
                self::NAME
            ),
            $events
        );

        $this->eventStore->appendTo($eventStream);
        $notification->clearEvents();

        Projector::instance()->project($events);
    }
}
