<?php

namespace Spec\Kreta\TaskManager\Domain\Model\Project\Task;

use Kreta\TaskManager\Domain\Model\Project\Task\PriorityNotAllowedException;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class PriorityNotAllowedExceptionSpec extends ObjectBehavior
{
    function let() 
    {
        $this->beConstructedWith('invalid-priority');
    }
    
    function it_is_initializable()
    {
        $this->shouldHaveType(PriorityNotAllowedException::class);
        $this->shouldHaveType(\Exception::class);
    }
    
    function it_returns_a_message()
    {
        $this->getMessage()->shouldReturn('Priority "invalid-priority" not allowed');
    }
}
