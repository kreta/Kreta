<?php

/**
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
 * Class RegisterNotifiersPass
 *
 * @package Kreta\Bundle\NotificationBundle\DependencyInjection\Compiler
 */
class RegisterNotifiersPass implements CompilerPassInterface
{
    /**
     * @{@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('kreta_notification.notifier_registry')) {
            return;
        }
        $registry = $container->getDefinition('kreta_notification.notifier_registry');
        foreach ($container->findTaggedServiceIds('kreta_notification.notifier') as $id => $attributes) {
            if (!isset($attributes[0]['label'])) {
                throw new \InvalidArgumentException('Tagged notifier needs to have `label` attribute.');
            }
            $name = $attributes[0]['label'];
            $registry->addMethodCall('registerNotifier', array($name, new Reference($id)));
        }
    }
}
