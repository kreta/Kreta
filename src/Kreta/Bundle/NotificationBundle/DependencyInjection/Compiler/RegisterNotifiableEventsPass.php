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

namespace Kreta\Bundle\NotificationBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class RegisterNotifiersPass.
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
