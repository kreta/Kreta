<?php

namespace spec\Kreta\Bundle\CoreBundle\DependencyInjection;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ConfigurationSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Bundle\CoreBundle\DependencyInjection\Configuration');
    }
}
