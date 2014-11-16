<?php

namespace spec\Kreta\Bundle\NotificationBundle\DependencyInjection;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ConfigurationSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Bundle\NotificationBundle\DependencyInjection\Configuration');
    }

    function it_gets_config_tree_builder()
    {
        $this->getConfigTreeBuilder()
            ->shouldReturnAnInstanceOf('Symfony\Component\Config\Definition\Builder\TreeBuilder');
    }
}
