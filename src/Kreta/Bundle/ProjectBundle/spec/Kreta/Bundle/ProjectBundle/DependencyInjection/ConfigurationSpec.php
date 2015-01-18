<?php

namespace spec\Kreta\Bundle\ProjectBundle\DependencyInjection;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ConfigurationSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Bundle\ProjectBundle\DependencyInjection\Configuration');
    }
}
