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

use Doctrine\Common\Collections\ArrayCollection;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Class IssueTypeSpec.
 *
 * @package spec\Kreta\Bundle\Api\ApiCoreBundle\Form\Type
 */
class IssueTypeSpec extends ObjectBehavior
{
    function let()
    {
        $participants = new ArrayCollection();
        $this->beConstructedWith($participants);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Bundle\Api\ApiCoreBundle\Form\Type\IssueType');
    }

    function it_extends_issue_type()
    {
        $this->shouldHaveType('Kreta\Bundle\CoreBundle\Form\Type\IssueType');
    }

    function it_gets_name()
    {
        $this->getName()->shouldReturn('');
    }
}
