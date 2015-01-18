<?php

namespace spec\Kreta\Bundle\ApiBundle\DependencyInjection;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ConfigurationSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Bundle\ApiBundle\DependencyInjection\Configuration');
    }
}
