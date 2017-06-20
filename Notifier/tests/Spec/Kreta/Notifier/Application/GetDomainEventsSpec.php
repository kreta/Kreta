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

namespace Spec\Kreta\Notifier\Application;

use Kreta\Notifier\Application\GetDomainEvents;
use Kreta\Notifier\Application\GetDomainEventsQuery;
use Kreta\Notifier\Application\GetDomainEventsResponse;
use Kreta\SharedKernel\Domain\Model\DomainEvent;
use Kreta\SharedKernel\Event\EventStore;
use PhpSpec\ObjectBehavior;

class GetDomainEventsSpec extends ObjectBehavior
{
    function it_can_be_created(
        EventStore $eventStore,
        GetDomainEventsResponse $response,
        GetDomainEventsQuery $query,
        \DateTimeImmutable $since,
        DomainEvent $event
    ) {
        $this->beConstructedWith($eventStore, $response);
        $this->shouldHaveType(GetDomainEvents::class);
        $query->page()->shouldBeCalled()->willReturn(1);
        $query->pageSize()->shouldBeCalled()->willReturn(25);
        $query->since()->shouldBeCalled()->willReturn($since);

        $eventStore->eventsSince($since, 0, 25)->shouldBeCalled()->willReturn([$event]);
        $response->build([$event], 1, 25)->shouldBeCalled();

        $this->__invoke($query)->shouldBeArray();
    }
}
