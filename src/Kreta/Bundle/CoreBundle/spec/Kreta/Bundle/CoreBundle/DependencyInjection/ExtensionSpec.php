<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\Bundle\CoreBundle\DependencyInjection;

use PhpSpec\ObjectBehavior;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Class ExtensionSpec.
 *
 * @package spec\Kreta\Bundle\CoreBundle\DependencyInjection
 */
class ExtensionSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Bundle\CoreBundle\DependencyInjection\Extension');
    }

    function it_loads_kreta_extension(ContainerBuilder $container)
    {
        $this->load([], $container);
    }
}
