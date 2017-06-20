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

namespace Kreta\SharedKernel\Infrastructure\Persistence\InMemory\EventStore;

use Kreta\SharedKernel\Domain\Model\AggregateDoesNotExistException;
use Kreta\SharedKernel\Domain\Model\DomainEvent;
use Kreta\SharedKernel\Domain\Model\DomainEventCollection;
use Kreta\SharedKernel\Event\EventStore;
use Kreta\SharedKernel\Event\Stream;
use Kreta\SharedKernel\Event\StreamName;

class InMemoryEventStore implements EventStore
{
    private $store;

    public function __construct()
    {
        $this->store = [];
    }

    public function append(Stream $stream) : void
    {
        foreach ($stream->events() as $event) {
            $content = [];
            $eventReflection = new \ReflectionClass($event);
            foreach ($eventReflection->getProperties() as $property) {
                $property->setAccessible(true);
                $content[$property->getName()] = $property->getValue($event);
            }

            $this->store[] = [
                'stream_name' => $stream->name()->name(),
                'type'        => get_class($event),
                'content'     => json_encode($content),
            ];
        }
    }

    public function streamOfName(StreamName $name) : Stream
    {
        $events = new DomainEventCollection();
        foreach ($this->store as $event) {
            if ($event['stream_name'] === $name->name()) {
                $events->add($this->buildEvent($event));
            }
        }
        if (0 === $events->count()) {
            throw new AggregateDoesNotExistException($name->aggregateId()->id());
        }

        return new Stream($name, $events);
    }

    public function eventsSince(?\DateTimeInterface $since, int $offset = 0, int $limit = -1) : array
    {
        $since = $since instanceof \DateTimeInterface ? $since->getTimestamp() : 0;

        $events = array_map(function (array $event) use ($since) {
            $domainEvent = $this->buildEvent($event);
            if ($domainEvent->occurredOn()->getTimestamp() >= $since) {
                $evenContent = json_decode($event['content'], true);
                $evenContent['occurredOn'] = $domainEvent->occurredOn()->getTimestamp();

                return [
                    'stream_name' => $event['stream_name'],
                    'type'        => $event['type'],
                    'content'     => $evenContent,
                ];
            }
        }, $this->store);

        return array_slice($events, $offset);
    }

    private function buildEvent(array $event) : DomainEvent
    {
        $eventData = json_decode($event['content']);
        $eventReflection = new \ReflectionClass($event['type']);
        $parameters = $eventReflection->getConstructor()->getParameters();
        $arguments = [];
        foreach ($parameters as $parameter) {
            foreach ($eventData as $key => $data) {
                if ($key === $parameter->getName()) {
                    $arguments[] = $data;
                }
            }
        }

        return new $event['type'](...$arguments);
    }
}
