<?php

namespace Spec\Kreta\IdentityAccess\Domain\Model;

use Kreta\IdentityAccess\Domain\Model\Uss;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class UssSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Uss::class);
    }
}
