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

namespace Spec\Kreta\SharedKernel\Domain\Model;

use Kreta\SharedKernel\Domain\Model\Collection;
use Kreta\SharedKernel\Domain\Model\EventStream;
use Kreta\SharedKernel\Domain\Model\Id;
use PhpSpec\ObjectBehavior;

class EventStreamSpec extends ObjectBehavior
{
    function let(Id $aggregateId, Collection $events)
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

    function it_gets_events(Collection $events)
    {
        $this->events()->shouldReturn($events);
    }
}
