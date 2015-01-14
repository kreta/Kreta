<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\Bundle\VCSBundle\DependencyInjection\Compiler;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

/**
 * Class RegisterSerializersPassSpec.
 *
 * @package spec\Kreta\Bundle\VCSBundle\DependencyInjection\Compiler
 */
class RegisterSerializersPassSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Bundle\VCSBundle\DependencyInjection\Compiler\RegisterSerializersPass');
    }

    function it_implements_compiler_pass_interface()
    {
        $this->shouldImplement('Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface');
    }

    function it_processes_the_serializers(ContainerBuilder $container, Definition $registry)
    {
        $container->hasDefinition('kreta_vcs.registry.serializer')->shouldBeCalled()->willReturn(true);
        $container->getDefinition('kreta_vcs.registry.serializer')->shouldBeCalled()->willReturn($registry);
        $container->findTaggedServiceIds('kreta_vcs.serializer')->shouldBeCalled()->willReturn([
            'kreta_vcs.serializer.github.commit' => [['provider' => 'github', 'event' => 'push']]
        ]);

        $registry->addMethodCall('registerSerializer', [
            'github', 'push', Argument::type('Symfony\Component\DependencyInjection\Reference')
        ]);

        $this->process($container);
    }

    function it_returns_if_registry_not_defined(ContainerBuilder $container)
    {
        $container->hasDefinition('kreta_vcs.registry.serializer')->shouldBeCalled()->willReturn(false);
        $container->getDefinition('kreta_vcs.registry.serializer')->shouldNotBeCalled();

        $this->process($container);
    }

    function it_throws_exception_if_attributes_missing(ContainerBuilder $container, Definition $registry)
    {
        $container->hasDefinition('kreta_vcs.registry.serializer')->shouldBeCalled()->willReturn(true);
        $container->getDefinition('kreta_vcs.registry.serializer')->shouldBeCalled()->willReturn($registry);
        $container->findTaggedServiceIds('kreta_vcs.serializer')->shouldBeCalled()->willReturn([
            'kreta_vcs.serializer.github.commit' => [[]]
        ]);

        $this->shouldThrow('\InvalidArgumentException')->duringProcess($container);
    }
}
