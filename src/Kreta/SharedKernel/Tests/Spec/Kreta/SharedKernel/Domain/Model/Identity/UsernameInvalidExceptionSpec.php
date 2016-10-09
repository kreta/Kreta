<?php

namespace Spec\Kreta\SharedKernel\Domain\Model\Identity;

use Kreta\SharedKernel\Domain\Model\InvalidArgumentException;
use Kreta\SharedKernel\Domain\Model\Identity\UsernameInvalidException;
use PhpSpec\ObjectBehavior;

class UsernameInvalidExceptionSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(UsernameInvalidException::class);
    }

    function it_extends_invalid_argument_exception()
    {
        $this->shouldHaveType(InvalidArgumentException::class);
    }
}
