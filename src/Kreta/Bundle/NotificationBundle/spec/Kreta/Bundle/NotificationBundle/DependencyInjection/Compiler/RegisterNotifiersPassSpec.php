<?php

/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\Kreta\Bundle\NotificationBundle\DependencyInjection\Compiler;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

/**
 * Class RegisterNotifiersPassSpec.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
 */
class RegisterNotifiersPassSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Bundle\NotificationBundle\DependencyInjection\Compiler\RegisterNotifiersPass');
    }

    function it_implements_compiler_pass_interface()
    {
        $this->shouldImplement('Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface');
    }

    function it_registers_notifiers(ContainerBuilder $container, Definition $definition)
    {
        $container->hasDefinition('kreta_notification.notifier_registry')->shouldBeCalled()->willReturn(true);

        $container->getDefinition('kreta_notification.notifier_registry')
            ->shouldBeCalled()->willReturn($definition);

        $container->findTaggedServiceIds('kreta_notification.notifier')
            ->shouldBeCalled()->willReturn([[["label" => "testEvent"]]]);

        $container->hasParameter('kreta_notification.notifier.testEvent.enabled')->shouldBeCalled()->willReturn(true);
        $container->getParameter('kreta_notification.notifier.testEvent.enabled')->shouldBeCalled()->willReturn(true);

        $definition->addMethodCall('registerNotifier',
            ['testEvent', Argument::type('Symfony\Component\DependencyInjection\Reference')]);

        $this->process($container);
    }

    function it_does_not_register_disbaled_notifiers(ContainerBuilder $container, Definition $definition)
    {
        $container->hasDefinition('kreta_notification.notifier_registry')->shouldBeCalled()->willReturn(true);

        $container->getDefinition('kreta_notification.notifier_registry')
            ->shouldBeCalled()->willReturn($definition);

        $container->findTaggedServiceIds('kreta_notification.notifier')
            ->shouldBeCalled()->willReturn([[["label" => "testEvent"]]]);

        $container->hasParameter('kreta_notification.notifier.testEvent.enabled')->shouldBeCalled()->willReturn(true);
        $container->getParameter('kreta_notification.notifier.testEvent.enabled')->shouldBeCalled()->willReturn(false);

        $definition->addMethodCall('registerNotifier',
            ['testEvent', Argument::type('Symfony\Component\DependencyInjection\Reference')])
            ->shouldNotBeCalled();

        $this->process($container);
    }

    function it_requires_label_to_be_present_to_register_notifiable_event(ContainerBuilder $container,
        Definition $definition)
    {
        $container->hasDefinition('kreta_notification.notifier_registry')->shouldBeCalled()->willReturn(true);

        $container->getDefinition('kreta_notification.notifier_registry')
            ->shouldBeCalled()->willReturn($definition);

        $container->findTaggedServiceIds('kreta_notification.notifier')
            ->shouldBeCalled()->willReturn([[["notLabelHere" => "asdas"]]]);

        $definition->addMethodCall('registerNotifier', Argument::any())->shouldNotBeCalled();

        $this->shouldThrow('\InvalidArgumentException')->duringProcess($container);
    }

    function it_leaves_if_notifiable_registry_is_not_defined(ContainerBuilder $container)
    {
        $container->hasDefinition('kreta_notification.notifier_registry')->shouldBeCalled()->willReturn(false);

        $container->getDefinition('kreta_notification.notifier_registry')->shouldNotBeCalled();

        $this->process($container);
    }
}

