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

namespace Spec\Kreta\SharedKernel\Event;

use Kreta\SharedKernel\Domain\Model\DomainEventCollection;
use Kreta\SharedKernel\Domain\Model\Identity\Id;
use Kreta\SharedKernel\Event\EventStream;
use PhpSpec\ObjectBehavior;

class EventStreamSpec extends ObjectBehavior
{
    function let(Id $aggregateId, DomainEventCollection $events)
    {
        $this->beConstructedWith($aggregateId, $events);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(EventStream::class);
    }

    function it_gets_aggregate_id(Id $aggregateId)
    {
        $this->aggregateId()->shouldReturn($aggregateId);
    }

    function it_gets_events(DomainEventCollection $events)
    {
        $this->events()->shouldReturn($events);
    }
}
