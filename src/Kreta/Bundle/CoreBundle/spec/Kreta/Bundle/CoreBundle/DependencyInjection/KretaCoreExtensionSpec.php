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

class KretaCoreExtensionSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Bundle\CoreBundle\DependencyInjection\KretaCoreExtension');
    }

    function it_loads(ContainerBuilder $container)
    {
        $this->load([], $container);
    }
}
