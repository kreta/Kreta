<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\Bundle\Api\ApiCoreBundle\Form\Type;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Class UserTypeSpec.
 *
 * @package spec\Kreta\Bundle\Api\ApiCoreBundle\Form\Type
 */
class UserTypeSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Bundle\Api\ApiCoreBundle\Form\Type\UserType');
    }

    function it_extends_user_type()
    {
        $this->shouldHaveType('Kreta\Bundle\CoreBundle\Form\Type\UserType');
    }

    function it_gets_name()
    {
        $this->getName()->shouldReturn('');
    }
}
