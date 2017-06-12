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
        $this->appendTo($stream);
    }

    function it_get_stream_of_name_given(Stream $stream, StreamName $streamName)
    {
        $eventCollection = new DomainEventCollection([
            new DomainEventStub('foo', 'bar'),
        ]);
        $stream->events()->shouldBeCalled()->willReturn($eventCollection);
        $stream->name()->shouldBeCalled()->willReturn($streamName);
        $streamName->name()->shouldBeCalled()->willReturn('dummy');
        $this->appendTo($stream);

        $this->streamOfName($streamName)->shouldReturnAnInstanceOf(Stream::class);
    }

    function it_does_not_get_any_aggregate(StreamName $streamName, Id $aggregateId)
    {
        $streamName->aggregateId()->shouldBeCalled()->willReturn($aggregateId);
        $aggregateId->id()->willReturn('id');

        $this->shouldThrow(AggregateDoesNotExistException::class)->duringStreamOfName($streamName);
    }
}
