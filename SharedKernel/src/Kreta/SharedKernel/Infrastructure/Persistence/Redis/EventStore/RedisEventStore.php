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

namespace Kreta\SharedKernel\Infrastructure\Persistence\Redis\EventStore;

use Kreta\SharedKernel\Domain\Model\AggregateDoesNotExistException;
use Kreta\SharedKernel\Domain\Model\Identity\Id;
use Kreta\SharedKernel\Event\EventStore;
use Kreta\SharedKernel\Event\EventStream;
use Predis\Client;

final class RedisEventStore implements EventStore
{
    private $predis;

    public function __construct(Client $predis)
    {
        $this->predis = $predis;
    }

    public function appendTo(EventStream $events) : void
    {
        foreach ($events as $event) {
            $data = serialize($event);

            $event = serialize([
                'type'       => get_class($event),
                'created_on' => (new \DateTimeImmutable())->getTimestamp(),
                'data'       => $data,
            ]);

            $this->predis->rpush('events:' . $events->aggregateId(), $event);
            $this->predis->rpush('published_events', $event);
        }
    }

    public function streamOfId(Id $aggregateId) : EventStream
    {
        if (!$this->predis->exists('events:' . $aggregateId->id())) {
            throw new AggregateDoesNotExistException($aggregateId->id());
        }

        $serializedEvents = $this->predis->lrange('events:' . $aggregateId->id(), 0, -1);

        $eventStream = [];
        foreach ($serializedEvents as $serializedEvent) {
            // TODO
        }

        return new EventStream($aggregateId, $eventStream);
    }
}
