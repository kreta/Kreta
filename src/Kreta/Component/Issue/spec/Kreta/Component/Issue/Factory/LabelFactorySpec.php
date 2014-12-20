<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\Component\Issue\Factory;

use PhpSpec\ObjectBehavior;

/**
 * Class LabelFactorySpec.
 *
 * @package spec\Kreta\Component\Issue\Factory
 */
class LabelFactorySpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('Kreta\Component\Issue\Model\Label');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Component\Issue\Factory\LabelFactory');
    }

    function it_creates_a_label()
    {
        $this->create()->shouldReturnAnInstanceOf('Kreta\Component\Issue\Model\Label');
    }
}
