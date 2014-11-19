<?php

namespace spec\Kreta\Component\Notification\Notifier\Registry;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class NonExistingNotifierExceptionSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('testNotifier');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Component\Notification\Notifier\Registry\NonExistingNotifierException');
    }

    function it_returns_message()
    {
        $this->getMessage()->shouldReturn('Notifier with name "testNotifier" does not exist');
    }
}
