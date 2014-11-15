<?php

namespace spec\Kreta\Component\Notification\Factory;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\Routing\RouterInterface;

class NotificationFactorySpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('Kreta\Component\Notification\Model\Notification');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Component\Notification\Factory\NotificationFactory');
    }

    function it_creates_notification()
    {
        $this->create()->shouldReturnAnInstanceOf(
            'Kreta\Component\Notification\Model\Interfaces\NotificationInterface'
        );
    }

}
