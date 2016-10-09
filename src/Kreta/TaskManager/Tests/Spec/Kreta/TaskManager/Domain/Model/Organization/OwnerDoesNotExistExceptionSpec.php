<?php

namespace Spec\Kreta\TaskManager\Domain\Model\Organization;

use Kreta\SharedKernel\Domain\Model\Exception;
use Kreta\TaskManager\Domain\Model\Organization\OwnerDoesNotExistException;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class OwnerDoesNotExistExceptionSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(OwnerDoesNotExistException::class);
    }

    function it_extends_exception()
    {
        $this->shouldHaveType(Exception::class);
    }
}
