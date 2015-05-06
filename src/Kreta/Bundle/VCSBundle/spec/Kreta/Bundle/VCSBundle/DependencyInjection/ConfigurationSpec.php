<?php

/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\Bundle\VCSBundle\DependencyInjection;

use PhpSpec\ObjectBehavior;

/**
 * Class ConfigurationSpec.
 *
 * @package spec\Kreta\Bundle\VCSBundle\DependencyInjection
 */
class ConfigurationSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Bundle\VCSBundle\DependencyInjection\Configuration');
    }

    function it_implements_configuration_interface()
    {
        $this->shouldImplement('Symfony\Component\Config\Definition\ConfigurationInterface');
    }

    function it_gets_config_tree_builder()
    {
        $this->getConfigTreeBuilder()
            ->shouldReturnAnInstanceOf('Symfony\Component\Config\Definition\Builder\TreeBuilder');
    }
}
