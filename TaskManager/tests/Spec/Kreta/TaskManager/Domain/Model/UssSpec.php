<?php

namespace Spec\Kreta\TaskManager\Domain\Model;

use Kreta\TaskManager\Domain\Model\Uss;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class UssSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Uss::class);
    }
}
