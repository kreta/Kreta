<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\Bundle\CoreBundle\DependencyInjection\Abstracts;

use PhpSpec\ObjectBehavior;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Class AbstractExtensionSpec.
 *
 * @package spec\Kreta\Bundle\CoreBundle\DependencyInjection\Abstracts
 */
class AbstractExtensionSpec extends ObjectBehavior
{
    function let()
    {
        $this->beAnInstanceOf('Kreta\Bundle\CoreBundle\Stubs\AbstractExtensionStub');
    }

    function it_loads_config(ContainerBuilder $container)
    {
        $this->load([], $container);
    }
}
