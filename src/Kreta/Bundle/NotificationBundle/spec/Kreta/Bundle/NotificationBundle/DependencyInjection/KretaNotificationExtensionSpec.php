<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\Bundle\NotificationBundle\DependencyInjection;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Class KretaNotificationExtensionSpec.
 *
 * @package spec\Kreta\Bundle\NotificationBundle\DependencyInjection
 */
class KretaNotificationExtensionSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Bundle\NotificationBundle\DependencyInjection\KretaNotificationExtension');
    }

    function it_extends_extension()
    {
        $this->shouldHaveType('Symfony\Component\DependencyInjection\Extension\Extension');
    }

    function it_loads_extension(ContainerBuilder $container)
    {
        $this->load([], $container);
    }
}
