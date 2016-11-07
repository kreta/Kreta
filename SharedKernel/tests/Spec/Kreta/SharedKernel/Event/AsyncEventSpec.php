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

namespace Spec\Kreta\SharedKernel\Event;

use Kreta\SharedKernel\Domain\Model\AsyncDomainEvent;
use Kreta\SharedKernel\Event\AsyncEvent;
use PhpSpec\ObjectBehavior;

class AsyncEventSpec extends ObjectBehavior
{
    function let(\DateTimeImmutable $occurredOn)
    {
        $this->beConstructedWith('Async event name', $occurredOn, [
            'user_id' => 'user-id',
        ]);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(AsyncEvent::class);
        $this->shouldImplement(AsyncDomainEvent::class);
    }

    function it_gets_name()
    {
        $this->name()->shouldReturn('Async event name');
    }

    function it_gets_values()
    {
        $this->values()->shouldReturn([
            'user_id' => 'user-id',
        ]);
    }

    function it_gets_occurred_on()
    {
        $this->occurredOn()->shouldReturnAnInstanceOf(\DateTimeInterface::class);
    }
}
