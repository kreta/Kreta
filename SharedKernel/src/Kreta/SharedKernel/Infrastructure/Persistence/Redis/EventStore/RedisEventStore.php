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
use Kreta\SharedKernel\Event\StoredEvent;
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

    public function append(Stream $stream) : void
    {
        $order = $this->countStoredEventsOfStream($stream) + 1;

        foreach ($stream->events() as $event) {
            $event = new StoredEvent(
                $order,
                $stream->name(),
                $event
            );

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

    public function eventsSince(?\DateTimeInterface $since, int $offset = 0, int $limit = -1) : array
    {
        $since = null === $since ? 0 : $since->getTimestamp();
        $keys = $this->predis->keys('*');

        $events = array_filter(call_user_func_array('array_merge', array_map(function ($key) use ($since) {
            return array_map(function (string $serializedEvent) {
                return json_decode($serializedEvent, true);
            }, $this->predis->lrange($key, 0, -1));
        }, $keys)), function (array $event) use ($since) {
            return $event['occurred_on'] >= $since;
        });

        return array_slice($events, $offset, $limit);
    }

    private function countStoredEventsOfStream(Stream $stream) : int
    {
        return count($this->predis->lrange($stream->name()->name(), 0, -1));
    }
}
