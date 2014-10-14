<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\CoreBundle\Model;

use PhpSpec\ObjectBehavior;

/**
 * Class ResolutionSpec.
 *
 * @package spec\Kreta\CoreBundle\Model
 */
class ResolutionSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\CoreBundle\Model\Resolution');
    }

    function it_extends_abstract_model()
    {
        $this->shouldHaveType('Kreta\CoreBundle\Model\Abstracts\AbstractModel');
    }

    function it_implements_status_interface()
    {
        $this->shouldImplement('Kreta\CoreBundle\Model\Interfaces\ResolutionInterface');
    }

    function its_description_is_mutable()
    {
        $this->setDescription('This is a dummy description of resolution')->shouldReturn($this);
        $this->getDescription()->shouldReturn('This is a dummy description of resolution');
    }
}
