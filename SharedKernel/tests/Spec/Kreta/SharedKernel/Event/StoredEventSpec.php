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

use Kreta\SharedKernel\Domain\Model\DomainEvent;
use Kreta\SharedKernel\Event\StoredEvent;
use Kreta\SharedKernel\Event\StreamName;
use PhpSpec\ObjectBehavior;

class StoredEventSpec extends ObjectBehavior
{
    function it_can_be_created(StreamName $name, DomainEvent $event, \DateTimeImmutable $occurredOn)
    {
        $this->beConstructedWith(1, $name, $event);
        $this->shouldHaveType(StoredEvent::class);
        $this->shouldImplement(DomainEvent::class);

        $name->name()->shouldBeCalled()->willReturn('user-1234567890');
        $event->occurredOn()->shouldBeCalled()->willReturn($occurredOn);

        $this->order()->shouldReturn(1);
        $this->name()->shouldReturn('1@user-1234567890');
        $this->occurredOn()->shouldReturn($occurredOn);
        $this->event()->shouldReturn($event);
    }
}
