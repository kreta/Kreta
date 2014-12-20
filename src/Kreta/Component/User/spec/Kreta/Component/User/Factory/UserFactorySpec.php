<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\Component\User\Factory;

use PhpSpec\ObjectBehavior;

/**
 * Class UserFactorySpec.
 *
 * @package spec\Kreta\Component\User\Factory
 */
class UserFactorySpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('Kreta\Component\User\Model\User');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Component\User\Factory\UserFactory');
    }

    function it_creates_a_user()
    {
        $this->create()->shouldReturnAnInstanceOf('Kreta\Component\User\Model\User');
    }
}
