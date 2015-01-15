<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\Bundle\NotificationBundle\DependencyInjection\Compiler;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

/**
 * Class RegisterNotifiableEventsPassSpec.
 *
 * @package spec\Kreta\Bundle\NotificationBundle\DependencyInjection\Compiler
 */
class RegisterNotifiableEventsPassSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Bundle\NotificationBundle\DependencyInjection\Compiler\RegisterNotifiableEventsPass');
    }

    function it_implements_compiler_pass_interface()
    {
        $this->shouldImplement('Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface');
    }

    function it_registers_notifiable_events(ContainerBuilder $container, Definition $definition)
    {
        $container->hasDefinition('kreta_notification.notifiable_event_registry')->shouldBeCalled()->willReturn(true);

        $container->getDefinition('kreta_notification.notifiable_event_registry')
            ->shouldBeCalled()->willReturn($definition);

        $container->findTaggedServiceIds('kreta_notification.notifiable_event')
            ->shouldBeCalled()->willReturn([[["label" => "asdas"]]]);

        $definition->addMethodCall('registerNotifiableEvent',
            ['testEvent', Argument::type('Symfony\Component\DependencyInjection\Reference')]);

        $this->process($container);
    }

    function it_requires_label_to_be_present_to_register_notifiable_event(ContainerBuilder $container,
                                                                          Definition $definition)
    {
        $container->hasDefinition('kreta_notification.notifiable_event_registry')->shouldBeCalled()->willReturn(true);

        $container->getDefinition('kreta_notification.notifiable_event_registry')
            ->shouldBeCalled()->willReturn($definition);

        $container->findTaggedServiceIds('kreta_notification.notifiable_event')
            ->shouldBeCalled()->willReturn([[["notLabelHere" => "asdas"]]]);

        $definition->addMethodCall('registerNotifiableEvent', Argument::any())->shouldNotBeCalled();

        $this->shouldThrow('\InvalidArgumentException')->duringProcess($container);
    }

    function it_leaves_if_notifiable_registry_is_not_defined(ContainerBuilder $container)
    {
        $container->hasDefinition('kreta_notification.notifiable_event_registry')->shouldBeCalled()->willReturn(false);

        $container->getDefinition('kreta_notification.notifiable_event_registry')->shouldNotBeCalled();

        $this->process($container);
    }
}
