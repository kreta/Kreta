<?php

namespace spec\Kreta\Component\VCS\Factory;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class BranchFactorySpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('Kreta\Component\VCS\Model\Branch');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Component\VCS\Factory\BranchFactory');
    }

    function it_creates_branch_model()
    {
        $this->create()->shouldReturnAnInstanceOf('Kreta\Component\VCS\Model\Branch');
    }
}
