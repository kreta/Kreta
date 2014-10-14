<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\CoreBundle\Factory;

use PhpSpec\ObjectBehavior;

/**
 * Class ResolutionFactorySpec.
 *
 * @package spec\Kreta\CoreBundle\Factory
 */
class ResolutionFactorySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\CoreBundle\Factory\ResolutionFactory');
    }

    function it_extends_abstract_factory()
    {
        $this->shouldHaveType('Kreta\CoreBundle\Factory\Abstracts\AbstractFactory');
    }

    function it_creates_a_resolution()
    {
        $this->create()->shouldReturnAnInstanceOf('Kreta\CoreBundle\Model\Resolution');
    }
}
