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

namespace spec\Kreta\Bundle\NotificationBundle;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Class KretaNotificationBundleSpec.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
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
