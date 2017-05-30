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
use Kreta\SharedKernel\Domain\Model\Identity\BaseId as Id;
use Kreta\SharedKernel\Event\EventStore;
use Kreta\SharedKernel\Event\EventStream;
use Kreta\SharedKernel\Infrastructure\Persistence\InMemory\EventStore\InMemoryEventStore;
use Kreta\SharedKernel\Tests\Double\Domain\Model\DomainEventStub;
use PhpSpec\ObjectBehavior;

class InMemoryEventStoreSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(InMemoryEventStore::class);
    }

    function it_implements_event_store()
    {
        $this->shouldImplement(EventStore::class);
    }

    function it_appends_to(EventStream $stream, Id $aggregateRootId)
    {
        $eventCollection = new DomainEventCollection([
            new DomainEventStub('foo', 'bar'),
        ]);
        $stream->events()->shouldBeCalled()->willReturn($eventCollection);
        $stream->aggregateRootId()->shouldBeCalled()->willReturn($aggregateRootId);
        $this->appendTo($stream);
    }

    function it_get_stream_of_id_given(EventStream $stream, Id $aggregateRootId)
    {
        $aggregateRootId->id()->willReturn('aggregate-id');
        $eventCollection = new DomainEventCollection([
            new DomainEventStub('foo', 'bar'),
        ]);
        $stream->events()->shouldBeCalled()->willReturn($eventCollection);
        $stream->aggregateRootId()->shouldBeCalled()->willReturn($aggregateRootId);
        $this->appendTo($stream);

        $this->streamOfId($aggregateRootId)->shouldReturnAnInstanceOf(EventStream::class);
    }

    function it_does_not_get_any_aggregate(Id $aggregateRootId)
    {
        $aggregateRootId->id()->willReturn('id');

        $this->shouldThrow(AggregateDoesNotExistException::class)->duringStreamOfId($aggregateRootId);
    }
}
