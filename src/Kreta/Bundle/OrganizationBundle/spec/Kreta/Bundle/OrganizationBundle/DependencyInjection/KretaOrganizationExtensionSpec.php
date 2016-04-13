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

namespace spec\Kreta\Bundle\OrganizationBundle\DependencyInjection;

use PhpSpec\ObjectBehavior;

/**
 * Spec file of KretaOrganizationExtension class.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 */
class KretaOrganizationExtensionSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Bundle\OrganizationBundle\DependencyInjection\KretaOrganizationExtension');
    }

    function it_extends_kreta_extension()
    {
        $this->shouldHaveType('Kreta\Bundle\CoreBundle\DependencyInjection\Extension');
    }
}
