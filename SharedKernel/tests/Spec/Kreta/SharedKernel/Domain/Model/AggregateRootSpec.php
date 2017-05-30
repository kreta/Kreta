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

namespace Spec\Kreta\SharedKernel\Domain\Model;

use Kreta\SharedKernel\Domain\Model\AggregateRoot;
use Kreta\SharedKernel\Domain\Model\Identity\Id;
use Kreta\SharedKernel\Event\EventStream;
use Kreta\SharedKernel\Tests\Double\Domain\Model\AggregateRootStub;
use PhpSpec\ObjectBehavior;

class AggregateRootSpec extends ObjectBehavior
{
    function let(Id $id)
    {
        $this->beAnInstanceOf(AggregateRootStub::class);

        $this->beConstructedWith($id);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(AggregateRoot::class);
    }

    function it_gets_recorded_events()
    {
        $this->recordedEvents()->shouldBeArray();
    }

    function it_gets_id(Id $id)
    {
        $this->id()->shouldReturn($id);
    }

    function it_publishes_an_event_like_event_sourcing()
    {
        $this->recordedEvents()->shouldHaveCount(0);
        $this->foo();
        $this->recordedEvents()->shouldHaveCount(1);
        $this->property()->shouldReturn('foo');
    }

    function it_publishes_an_event_like_cqrs()
    {
        $this->recordedEvents()->shouldHaveCount(0);
        $this->bar();
        $this->recordedEvents()->shouldHaveCount(1);
        $this->property()->shouldReturn('bar');
    }

    function it_reconstitutes_the_aggregate_root(EventStream $events, Id $aggregateRootId)
    {
        $events->aggregateRootId()->shouldBeCalled()->willReturn($aggregateRootId);
        $this::reconstitute($events)->shouldReturnAnInstanceOf(AggregateRoot::class);
    }
}
