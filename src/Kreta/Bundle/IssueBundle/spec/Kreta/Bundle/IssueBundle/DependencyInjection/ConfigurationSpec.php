<?php

namespace spec\Kreta\Bundle\IssueBundle\DependencyInjection;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ConfigurationSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Bundle\IssueBundle\DependencyInjection\Configuration');
    }
}
