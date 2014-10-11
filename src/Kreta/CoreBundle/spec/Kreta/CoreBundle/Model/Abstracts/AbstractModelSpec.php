<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\CoreBundle\Model\Abstracts;

use PhpSpec\ObjectBehavior;

/**
 * Class AbstractModelSpec.
 *
 * @package spec\Kreta\CoreBundle\Model\Abstracts
 */
class AbstractModelSpec extends ObjectBehavior
{
    function let()
    {
        $this->beAnInstanceOf('Kreta\CoreBundle\Stubs\Model\Abstracts\AbstractModelStub');
    }

    function it_does_not_have_id_by_default()
    {
        $this->getId()->shouldReturn(null);
    }

    function its_id_is_mutable()
    {
        $this->setId('dummy-id')->shouldReturn($this);
        $this->getId()->shouldReturn('dummy-id');
    }

    function its_toString_returns_null_if_its_id_is_null()
    {
        $this->__toString()->shouldReturn(null);
    }

    function its_toString_returns_a_string()
    {
        $this->setId('dummy-id')->shouldReturn($this);
        $this->__toString()->shouldReturn('dummy-id');
    }
}
