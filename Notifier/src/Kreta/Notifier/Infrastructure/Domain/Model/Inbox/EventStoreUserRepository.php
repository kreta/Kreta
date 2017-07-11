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

namespace Kreta\Notifier\Infrastructure\Domain\Model\Inbox;

use Kreta\Notifier\Domain\Model\Inbox\User;
use Kreta\Notifier\Domain\Model\Inbox\UserDoesNotExist;
use Kreta\Notifier\Domain\Model\Inbox\UserId;
use Kreta\Notifier\Domain\Model\Inbox\UserRepository;
use Kreta\SharedKernel\Domain\Model\AggregateDoesNotExistException;
use Kreta\SharedKernel\Domain\Model\DomainEventCollection;
use Kreta\SharedKernel\Event\EventStore;
use Kreta\SharedKernel\Event\Stream;
use Kreta\SharedKernel\Event\StreamName;
use Kreta\SharedKernel\Projection\Projector;

final class EventStoreUserRepository implements UserRepository
{
    private const NAME = 'user';

    private $eventStore;

    public function __construct(EventStore $eventStore)
    {
        $this->eventStore = $eventStore;
    }

    public function get(UserId $id) : User
    {
        try {
            return User::reconstitute(
                $this->eventStore->streamOfName(
                    new StreamName(
                        $id,
                        self::NAME
                    )
                )
            );
        } catch (AggregateDoesNotExistException $exception) {
            throw new UserDoesNotExist();
        }
    }

    public function save(User $user) : void
    {
        $events = new DomainEventCollection($user->recordedEvents());

        $eventStream = new Stream(
            new StreamName(
                $user->id(),
                self::NAME
            ),
            $events
        );

        $this->eventStore->appendTo($eventStream);
        $user->clearEvents();

        Projector::instance()->project($events);
    }
}
