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

namespace Kreta\SharedKernel\Infrastructure\Persistence\EventStore;

use Kreta\SharedKernel\Domain\Model\AggregateDoesNotExistException;
use Kreta\SharedKernel\Domain\Model\DomainEventCollection;
use Kreta\SharedKernel\Domain\Model\EventStore;
use Kreta\SharedKernel\Domain\Model\EventStream;
use Kreta\SharedKernel\Domain\Model\Identity\Id;

class InMemoryEventStore implements EventStore
{
    private $store;

    public function __construct()
    {
        $this->store = [];
    }

    public function appendTo(EventStream $stream)
    {
        foreach ($stream->events() as $event) {
            $content = [];
            $eventReflection = new \ReflectionClass($event);
            foreach ($eventReflection->getProperties() as $property) {
                $property->setAccessible(true);
                $content[$property->getName()] = $property->getValue($event);
            }

            $this->store[] = [
                'stream_id' => $stream->aggregateId(),
                'type'      => get_class($event),
                'content'   => json_encode($content),
            ];
        }
    }

    public function streamOfId(Id $aggregateId) : EventStream
    {
        $events = new DomainEventCollection();
        foreach ($this->store as $event) {
            if ($event['stream_id'] === $aggregateId) {
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
                $events->add(new $event['type'](...$arguments));
            }
        }
        if (0 === $events->count()) {
            throw new AggregateDoesNotExistException($aggregateId);
        }

        return new EventStream($aggregateId, $events);
    }
}
