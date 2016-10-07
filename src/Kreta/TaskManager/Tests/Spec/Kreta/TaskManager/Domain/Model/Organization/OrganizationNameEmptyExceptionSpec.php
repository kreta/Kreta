<?php

namespace Spec\Kreta\TaskManager\Domain\Model\Organization;

use Kreta\TaskManager\Domain\Model\Organization\OrganizationNameEmptyException;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class OrganizationNameEmptyExceptionSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(OrganizationNameEmptyException::class);
        $this->shouldHaveType(\Exception::class);
    }

    function it_should_return_message()
    {
        $this->getMessage()->shouldReturn('Organization name must not be empty');
    }
}
