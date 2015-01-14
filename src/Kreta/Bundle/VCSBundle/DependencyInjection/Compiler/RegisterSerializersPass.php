<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Bundle\VCSBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class RegisterSerializersPass.
 *
 * @package Kreta\Bundle\VCSBundle\DependencyInjection\Compiler
 */
class RegisterSerializersPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('kreta_vcs.registry.serializer')) {
            return;
        }
        $registry = $container->getDefinition('kreta_vcs.registry.serializer');
        foreach ($container->findTaggedServiceIds('kreta_vcs.serializer') as $id => $attributes) {
            if (!isset($attributes[0]['provider']) && !isset($attributes[0]['event'])) {
                throw new \InvalidArgumentException(
                    'Tagged serializers need to have `provider` and `event` attributes.'
                );
            }
            $registry->addMethodCall('registerSerializer', [
                $attributes[0]['provider'], $attributes[0]['event'], new Reference($id)
            ]);
        }
    }
}
