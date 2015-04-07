<?php

/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\Component\VCS\Event;

use Kreta\Component\VCS\Model\Interfaces\BranchInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Class NewBranchEventSpec.
 *
 * @package spec\Kreta\Component\VCS\Event
 */
class NewBranchEventSpec extends ObjectBehavior
{
    function let(BranchInterface $branch)
    {
        $this->beConstructedWith($branch);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Component\VCS\Event\NewBranchEvent');
    }

    function it_extends_event()
    {
        $this->shouldHaveType('Symfony\Component\EventDispatcher\Event');
    }

    function it_gets_branch(BranchInterface $branch)
    {
        $this->getBranch()->shouldReturn($branch);
    }
}
