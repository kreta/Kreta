<?php

namespace spec\Kreta\Component\VCS\Model;

use Kreta\Component\VCS\Model\Interfaces\RepositoryInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class BranchSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Component\VCS\Model\Branch');
    }

    function its_id_is_mutable()
    {
        $this->setId('1111')->shouldReturn($this);
        $this->getId()->shouldReturn('1111');
    }

    function its_name_is_mutable()
    {
        $this->setName('master')->shouldReturn($this);
        $this->getName()->shouldReturn('master');
    }

    function its_repository_is_mutable(RepositoryInterface $repository)
    {
        $this->setRepository($repository)->shouldReturn($this);
        $this->getRepository()->shouldReturn($repository);
    }
}
