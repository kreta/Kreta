<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\Component\Core\Factory;

use PhpSpec\ObjectBehavior;

/**
 * Class BaseFactorySpec.
 *
 * @package spec\Kreta\Component\Core\Factory
 */
class BaseFactorySpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('Kreta\Component\Core\Model\Comment');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Component\Core\Factory\BaseFactory');
    }

    function it_creates_a_comment()
    {
        $this->create()->shouldReturnAnInstanceOf('Kreta\Component\Core\Model\Comment');
    }
}
