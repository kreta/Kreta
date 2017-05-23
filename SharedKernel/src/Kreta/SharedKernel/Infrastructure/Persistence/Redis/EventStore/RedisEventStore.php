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

use JMS\Serializer\Serializer;
use Kreta\SharedKernel\Domain\Model\AggregateDoesNotExistException;
use Kreta\SharedKernel\Domain\Model\DomainEventCollection;
use Kreta\SharedKernel\Domain\Model\Identity\Id;
use Kreta\SharedKernel\Event\EventStore;
use Kreta\SharedKernel\Event\EventStream;
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
            $data = $this->serializer->serialize($event, 'json');

            $serializedEvent = $this->serializer->serialize(
                [
                    'type'       => get_class($event),
                    'created_on' => (new \DateTimeImmutable())->getTimestamp(),
                    'data'       => $data,
                ],
                'json'
            );

            $this->predis->rpush($this->redisKey($stream->aggregateId()), $serializedEvent);
        }
    }

    public function streamOfId(Id $aggregateId) : EventStream
    {
        if (!$this->predis->exists($this->redisKey($aggregateId))) {
            throw new AggregateDoesNotExistException($aggregateId->id());
        }

        $serializedEvents = $this->predis->lrange($this->redisKey($aggregateId), 0, -1);

        $events = new DomainEventCollection();
        foreach ($serializedEvents as $serializedEvent) {
            $eventData = $this->serializer->deserialize($serializedEvent, 'array', 'json');

            $events->add(
                $this->serializer->deserialize(
                    $eventData['data'],
                    $eventData['type'],
                    'json'
                )
            );
        }

        return new EventStream($aggregateId, $events);
    }

    private function redisKey(Id $aggregateId)
    {
        return sprintf(self::REDIS_KEY_PLACEHOLDER, $aggregateId->id());
    }
}
