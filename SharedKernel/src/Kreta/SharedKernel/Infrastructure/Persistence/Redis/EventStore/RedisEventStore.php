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

    public function __construct(Client $predis, Serializer $serializer)
    {
        $this->predis = $predis;
        $this->serializer = $serializer;
    }

    public function appendTo(Stream $stream) : void
    {
        foreach ($stream->events() as $event) {
            $this->predis->rpush(
                $stream->name()->name(),
                $this->serializer->serialize($event)
            );
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
            $events->add(
                $this->serializer->deserialize($serializedEvent)
            );
        }

        return new Stream($name, $events);
    }
}
