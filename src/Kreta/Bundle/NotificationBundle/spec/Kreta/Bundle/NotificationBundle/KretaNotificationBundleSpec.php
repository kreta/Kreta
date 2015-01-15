<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\Bundle\NotificationBundle;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Class KretaNotificationBundleSpec.
 *
 * @package spec\Kreta\Bundle\NotificationBundle
 */
class KretaNotificationBundleSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Bundle\NotificationBundle\KretaNotificationBundle');
    }

    function it_extends_bundle()
    {
        $this->shouldHaveType('Symfony\Component\HttpKernel\Bundle\Bundle');
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
