<?php

/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Bundle\NotificationBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class RegisterNotifiersPass.
 *
 * @package Kreta\Bundle\NotificationBundle\DependencyInjection\Compiler
 */
class RegisterNotifiableEventsPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('kreta_notification.notifiable_event_registry')) {
            return;
        }
        $registry = $container->getDefinition('kreta_notification.notifiable_event_registry');
        foreach ($container->findTaggedServiceIds('kreta_notification.notifiable_event') as $id => $attributes) {
            if (!isset($attributes[0]['label'])) {
                throw new \InvalidArgumentException('Tagged notifiable event needs to have `label` attribute.');
            }
            $name = $attributes[0]['label'];
            $registry->addMethodCall('registerNotifiableEvent', [$name, new Reference($id)]);
        }
    }
}
