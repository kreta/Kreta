<?php

namespace spec\Kreta\Component\VCS\Event;

use Kreta\Component\VCS\Model\Interfaces\BranchInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

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

    function it_gets_branch(BranchInterface $branch)
    {
        $this->getBranch()->shouldReturn($branch);
    }
}
