<?php

namespace spec\Kreta\Bundle\WebBundle\DependencyInjection;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ConfigurationSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Bundle\WebBundle\DependencyInjection\Configuration');
    }
}
