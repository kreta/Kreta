<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\Bundle\ApiBundle\DependencyInjection;

use PhpSpec\ObjectBehavior;

class KretaApiExtensionSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Bundle\ApiBundle\DependencyInjection\KretaApiExtension');
    }

    function it_extends_kreta_extension()
    {
        $this->shouldHaveType('Kreta\Bundle\CoreBundle\DependencyInjection\Extension');
    }
}
