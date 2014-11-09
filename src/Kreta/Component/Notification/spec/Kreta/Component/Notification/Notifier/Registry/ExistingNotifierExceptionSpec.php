<?php

namespace spec\Kreta\Component\Notification\Notifier\Registry;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ExistingNotifierExceptionSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('testNotifier');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Component\Notification\Notifier\Registry\ExistingNotifierException');
    }

    function it_returns_message()
    {
        $this->getMessage()->shouldReturn('Notifier with name "testNotifier" already exists');
    }
}
