<?php

namespace spec\Kreta\Bundle\NotificationBundle\DependencyInjection;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class KretaNotificationExtensionSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Bundle\NotificationBundle\DependencyInjection\KretaNotificationExtension');
    }

    function it_loads_extension(ContainerBuilder $container)
    {
        $this->load(array(), $container);
    }

    function it_gets_alias()
    {
        $this->getAlias()->shouldReturn('kreta_notification');
    }
}
