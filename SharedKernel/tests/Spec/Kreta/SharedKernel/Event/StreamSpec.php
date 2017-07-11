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
use Kreta\SharedKernel\Event\Stream;
use Kreta\SharedKernel\Event\StreamName;
use PhpSpec\ObjectBehavior;

class StreamSpec extends ObjectBehavior
{
    function it_can_be_created(StreamName $streamName, DomainEventCollection $events)
    {
        $this->beConstructedWith($streamName, $events);
        $this->shouldHaveType(Stream::class);
        $this->name()->shouldReturn($streamName);
        $this->events()->shouldReturn($events);
    }
}
