<?php

namespace Spec\Kreta\SharedKernel\Domain\Model\Identity;

use Kreta\SharedKernel\Domain\Model\Identity\EmailAddressInvalidException;
use Kreta\SharedKernel\Domain\Model\InvalidArgumentException;
use PhpSpec\ObjectBehavior;

class EmailAddressInvalidExceptionSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(EmailAddressInvalidException::class);
    }

    function it_extends_invalid_argument_exception()
    {
        $this->shouldHaveType(InvalidArgumentException::class);
    }
}
