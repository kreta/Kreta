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
use Kreta\SharedKernel\Domain\Model\DomainEventCollection;
use Kreta\SharedKernel\Domain\Model\Identity\BaseId as Id;
use Kreta\SharedKernel\Event\EventStore;
use Kreta\SharedKernel\Event\EventStream;
use Kreta\SharedKernel\Serialization\Serializer;
use Predis\Client;

final class RedisEventStore implements EventStore
{
    private const REDIS_KEY_PLACEHOLDER = 'events: %s';

    private $predis;
    private $serializer;

    public function __construct(Client $predis, Serializer $serializer)
    {
        $this->predis = $predis;
        $this->serializer = $serializer;
    }

    public function appendTo(EventStream $stream) : void
    {
        foreach ($stream->events() as $event) {
            $serializedEvent = $this->serializer->serialize(
                [
                    'type'       => get_class($event),
                    'created_on' => (new \DateTimeImmutable())->getTimestamp(),
                    'data'       => $this->serializer->serialize($event),
                ]
            );

            $this->predis->rpush($this->redisKey($stream->aggregateRootId()), $serializedEvent);
        }
    }

    public function streamOfId(Id $aggregateRootId) : EventStream
    {
        if (!$this->predis->exists($this->redisKey($aggregateRootId))) {
            throw new AggregateDoesNotExistException($aggregateRootId->id());
        }

        $serializedEvents = $this->predis->lrange($this->redisKey($aggregateRootId), 0, -1);

        $events = new DomainEventCollection();
        foreach ($serializedEvents as $serializedEvent) {
            $eventData = $this->serializer->deserialize($serializedEvent, 'array');

            $events->add(
                $this->serializer->deserialize(
                    $eventData['data'],
                    $eventData['type']
                )
            );
        }

        return new EventStream($aggregateRootId, $events);
    }

    private function redisKey(Id $aggregateRootId)
    {
        return sprintf(self::REDIS_KEY_PLACEHOLDER, $aggregateRootId->id());
    }
}
