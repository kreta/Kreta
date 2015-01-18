<?php

namespace spec\Kreta\Bundle\MediaBundle\DependencyInjection;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ConfigurationSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Bundle\MediaBundle\DependencyInjection\Configuration');
    }
}
