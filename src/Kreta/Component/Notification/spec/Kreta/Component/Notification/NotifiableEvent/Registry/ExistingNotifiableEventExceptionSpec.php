<?php

namespace spec\Kreta\Component\Notification\NotifiableEvent\Registry;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ExistingNotifiableEventExceptionSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('testEvent');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Component\Notification\NotifiableEvent\Registry\ExistingNotifiableEventException');
    }

    function it_returns_message()
    {
        $this->getMessage()->shouldReturn('Notifiable event with name "testEvent" already exists');
    }
}
