<?php

namespace spec\Kreta\Component\Notification\NotifiableEvent\Registry;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class NonExistingNotifiableEventExceptionSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('testEvent');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Component\Notification\NotifiableEvent\Registry\NonExistingNotifiableEventException');
    }

    function it_returns_message()
    {
        $this->getMessage()->shouldReturn('Notifiable event with name "testEvent" does not exist');
    }
}
