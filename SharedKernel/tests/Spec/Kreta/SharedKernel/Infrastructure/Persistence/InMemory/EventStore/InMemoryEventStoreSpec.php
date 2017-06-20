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

namespace Spec\Kreta\SharedKernel\Infrastructure\Persistence\InMemory\EventStore;

use Kreta\SharedKernel\Domain\Model\AggregateDoesNotExistException;
use Kreta\SharedKernel\Domain\Model\DomainEventCollection;
use Kreta\SharedKernel\Domain\Model\Identity\Id;
use Kreta\SharedKernel\Event\EventStore;
use Kreta\SharedKernel\Event\Stream;
use Kreta\SharedKernel\Event\StreamName;
use Kreta\SharedKernel\Infrastructure\Persistence\InMemory\EventStore\InMemoryEventStore;
use Kreta\SharedKernel\Tests\Double\Domain\Model\DomainEventStub;
use PhpSpec\ObjectBehavior;

class InMemoryEventStoreSpec extends ObjectBehavior
{
    function it_appends_to(Stream $stream, StreamName $streamName)
    {
        $this->shouldHaveType(InMemoryEventStore::class);
        $this->shouldImplement(EventStore::class);

        $eventCollection = new DomainEventCollection([
            new DomainEventStub('foo', 'bar'),
        ]);
        $stream->events()->shouldBeCalled()->willReturn($eventCollection);
        $stream->name()->shouldBeCalled()->willReturn($streamName);
        $streamName->name()->shouldBeCalled()->willReturn('dummy');
        $this->append($stream);
    }

    function it_get_stream_of_name_given(Stream $stream, StreamName $streamName)
    {
        $eventCollection = new DomainEventCollection([
            new DomainEventStub('foo', 'bar'),
        ]);
        $stream->events()->shouldBeCalled()->willReturn($eventCollection);
        $stream->name()->shouldBeCalled()->willReturn($streamName);
        $streamName->name()->shouldBeCalled()->willReturn('dummy');
        $this->append($stream);

        $this->streamOfName($streamName)->shouldReturnAnInstanceOf(Stream::class);
    }

    function it_does_not_get_any_aggregate(StreamName $streamName, Id $aggregateId)
    {
        $streamName->aggregateId()->shouldBeCalled()->willReturn($aggregateId);
        $aggregateId->id()->willReturn('id');

        $this->shouldThrow(AggregateDoesNotExistException::class)->duringStreamOfName($streamName);
    }

    function it_gets_events_since_given_date(\DateTimeImmutable $since, Stream $stream, StreamName $streamName)
    {
        $domainEvent = new DomainEventStub('foo', 'bar');
        $eventCollection = new DomainEventCollection([$domainEvent]);
        $stream->events()->shouldBeCalled()->willReturn($eventCollection);
        $stream->name()->shouldBeCalled()->willReturn($streamName);
        $streamName->name()->shouldBeCalled()->willReturn('dummy');
        $this->append($stream);

        $this->eventsSince($since)->shouldReturn([
            [
                'stream_name' => 'dummy',
                'type'        => DomainEventStub::class,
                'content'     => [
                    'bar'        => 'bar',
                    'foo'        => 'foo',
                    'occurredOn' => $domainEvent->occurredOn()->getTimestamp(),
                ],
            ],
        ]);
    }

    function it_gets_empty_events_when_since_is_higher_than_persisted_events_occurred_on(
        \DateTimeImmutable $since,
        Stream $stream,
        StreamName $streamName
    ) {
        $domainEvent = new DomainEventStub('foo', 'bar');
        $eventCollection = new DomainEventCollection([$domainEvent]);
        $stream->events()->shouldBeCalled()->willReturn($eventCollection);
        $stream->name()->shouldBeCalled()->willReturn($streamName);
        $streamName->name()->shouldBeCalled()->willReturn('dummy');
        $this->append($stream);

        $since->getTimestamp()->willReturn($domainEvent->occurredOn()->getTimestamp() + 10);

        $this->eventsSince($since)->shouldReturn([null]);
    }
}
