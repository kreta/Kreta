<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\Bundle\IssueBundle\Form\Type\Api;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Class PriorityTypeSpec.
 *
 * @package spec\Kreta\Bundle\IssueBundle\Form\Type\Api
 */
class PriorityTypeSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Bundle\IssueBundle\Form\Type\Api\PriorityType');
    }

    function it_extends_priority_type()
    {
        $this->shouldHaveType('Kreta\Bundle\IssueBundle\Form\Type\PriorityType');
    }

    function it_gets_name()
    {
        $this->getName()->shouldReturn('');
    }
}
