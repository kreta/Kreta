<?php

/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\Bundle\IssueBundle\DependencyInjection;

use PhpSpec\ObjectBehavior;

/**
 * Class KretaIssueExtensionSpec.
 *
 * @package spec\Kreta\Bundle\IssueBundle\DependencyInjection
 */
class KretaIssueExtensionSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Bundle\IssueBundle\DependencyInjection\KretaIssueExtension');
    }

    function it_extends_kreta_extension()
    {
        $this->shouldHaveType('Kreta\Bundle\CoreBundle\DependencyInjection\Extension');
    }
}
