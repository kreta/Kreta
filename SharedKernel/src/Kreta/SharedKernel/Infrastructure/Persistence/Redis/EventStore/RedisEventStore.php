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
use Kreta\SharedKernel\Event\EventStore;
use Kreta\SharedKernel\Event\Stream;
use Kreta\SharedKernel\Event\StreamName;
use Kreta\SharedKernel\Serialization\Serializer;
use Predis\Client;

final class RedisEventStore implements EventStore
{
    private $predis;
    private $serializer;
    private $eventType;

    public function __construct(Client $predis, Serializer $serializer, string $eventType = null)
    {
        $this->predis = $predis;
        $this->serializer = $serializer;
        $this->eventType = $eventType;
    }

    public function appendTo(Stream $stream) : void
    {
        foreach ($stream->events() as $event) {
            $serializedEvent = $this->serializer->serialize(
                [
                    'type' => get_class($event),
                    'data' => $this->serializer->serialize($event),
                ]
            );

            $this->predis->rpush($stream->name()->name(), $serializedEvent);
        }
    }

    public function streamOfName(StreamName $name) : Stream
    {
        if (!$this->predis->exists($name->name())) {
            throw new AggregateDoesNotExistException($name->aggregateId()->id());
        }

        $serializedEvents = $this->predis->lrange($name->name(), 0, -1);

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

        return new Stream($name, $events);
    }
}
