<?php

/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\Bundle\UserBundle;

use PhpSpec\ObjectBehavior;

/**
 * Class KretaUserBundleSpec.
 *
 * @package spec\Kreta\UserBundle
 */
class KretaUserBundleSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Bundle\UserBundle\KretaUserBundle');
    }

    function it_extends_bundle()
    {
        $this->shouldHaveType('Symfony\Component\HttpKernel\Bundle\Bundle');
    }
    
    function it_gets_parent()
    {
        $this->getParent()->shouldReturn('FOSUserBundle');
    }
}
