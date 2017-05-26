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

namespace Spec\Kreta\SharedKernel\Projection;

use Kreta\SharedKernel\Domain\Model\DomainEventCollection;
use Kreta\SharedKernel\Domain\Model\Exception;
use Kreta\SharedKernel\Projection\EventHandler;
use Kreta\SharedKernel\Tests\Double\Domain\Model\DomainEventStub;
use Kreta\SharedKernel\Tests\Double\Domain\Model\EventSourcingEventStub;
use PhpSpec\ObjectBehavior;

class ProjectorSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedInstance();
    }

    function it_cannot_be_cloned()
    {
        $this->shouldThrow(new Exception('Clone is not supported'))->during__clone();
    }

    function it_cannot_project_events_that_not_match_with_registered_handlers(
        DomainEventCollection $events,
        EventHandler $eventHandler
    ) {
        $event = new EventSourcingEventStub();

        $eventHandler->eventType()->shouldBeCalled()->willReturn(DomainEventStub::class);
        $this->register([$eventHandler]);
        $events->toArray()->shouldBeCalled()->willReturn([$event]);
        $eventHandler->handle($event)->shouldNotBeCalled();
        $this->project($events);
    }

    function it_cannot_project_events(DomainEventCollection $events, EventHandler $eventHandler)
    {
        $event = new DomainEventStub('foo', 'bar');

        $eventHandler->eventType()->shouldBeCalled()->willReturn(DomainEventStub::class);
        $this->register([$eventHandler]);
        $events->toArray()->shouldBeCalled()->willReturn([$event]);
        $eventHandler->handle($event)->shouldBeCalled();
        $this->project($events);
    }
}
