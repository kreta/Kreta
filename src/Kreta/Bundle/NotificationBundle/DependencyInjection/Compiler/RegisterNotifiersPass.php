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
class RegisterNotifiersPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
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
            if (!$container->hasParameter(
                    sprintf('kreta_notification.notifier.%s.enabled', $attributes[0]['label'])
                )
                || $container->getParameter(
                    sprintf('kreta_notification.notifier.%s.enabled', $attributes[0]['label'])
                ) === true
            ) {
                $name = $attributes[0]['label'];
                $registry->addMethodCall('registerNotifier', [$name, new Reference($id)]);
            }
        }
    }
}
