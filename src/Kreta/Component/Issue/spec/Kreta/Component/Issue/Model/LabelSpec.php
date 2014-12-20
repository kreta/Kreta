<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\Component\Issue\Model;

use PhpSpec\ObjectBehavior;

/**
 * Class LabelSpec.
 *
 * @package spec\Kreta\Component\Issue\Model
 */
class LabelSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Component\Issue\Model\Label');
    }

    function it_extends_abstract_model()
    {
        $this->shouldHaveType('Kreta\Component\Core\Model\Abstracts\AbstractModel');
    }

    function it_implements_label_interface()
    {
        $this->shouldImplement('Kreta\Component\Issue\Model\Interfaces\LabelInterface');
    }

    function it_name_is_mutable()
    {
        $this->setName('The dummy label')->shouldReturn($this);
        $this->getName()->shouldReturn('the-dummy-label');
    }
}
