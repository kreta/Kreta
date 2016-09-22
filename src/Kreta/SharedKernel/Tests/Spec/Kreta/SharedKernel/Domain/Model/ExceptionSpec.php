<?php

namespace Spec\Kreta\SharedKernel\Domain\Model;

use Kreta\SharedKernel\Domain\Model\Exception;
use PhpSpec\ObjectBehavior;

class ExceptionSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Exception::class);
    }

    function it_extends_php_exception()
    {
        $this->shouldHaveType(\Exception::class);
    }
}
