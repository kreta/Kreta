<?php

namespace spec\Kreta\Bundle\NotificationBundle;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class KretaNotificationBundleSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Bundle\NotificationBundle\KretaNotificationBundle');
    }

    function it_builds_bundle(ContainerBuilder $container)
    {
        $container->addCompilerPass(
            Argument::type('Kreta\Bundle\NotificationBundle\DependencyInjection\Compiler\RegisterNotifiableEventsPass')
        )->shouldBeCalled();
        $container->addCompilerPass(
            Argument::type('Kreta\Bundle\NotificationBundle\DependencyInjection\Compiler\RegisterNotifiersPass')
        )->shouldBeCalled();

        $this->build($container);
    }


}
