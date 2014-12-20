<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Bundle\ApiBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class Configuration.
 *
 * @package Kreta\Bundle\ApiBundle\DependencyInjection
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('kreta_api');

//        $rootNode
//            ->children()
//                ->arrayNode('jms_serializer')
//                    ->children()
//                        ->arrayNode('metadata')
//                            ->addDefaultsIfNotSet()
//                            ->children()
//                                ->arrayNode('directories')
//                                    ->prototype('array')
//                                        ->children()
//                                            ->scalarNode('path')->defaultValue('Kreta\\Component\\Core')->end()
//                                            ->scalarNode('namespace_prefix')->defaultValue('@KretaApiBundle/Resources/config/serializer')->end()
//                                        ->end()
//                                    ->end()
//                                ->end()
//                            ->end()
//                        ->end()
//                    ->end()
//                ->end()
//            ->end();
                    
                    
//                    ->scalarNode('cache')->defaultValue('file')->end()
//                    ->arrayNode('file_cache')
//                        ->addDefaultsIfNotSet()
//                        ->children()
//                            ->scalarNode('dir')->defaultValue('%kernel.cache_dir%/hateoas')->end()
//                        ->end()
//                    ->end()
//                ->end()
//            ->end()
//            ->arrayNode('serializer')
//                ->addDefaultsIfNotSet()
//                ->children()
//                    ->scalarNode('json')->defaultValue('hateoas.serializer.json_hal')->end()
//                    ->scalarNode('xml')->defaultValue('hateoas.serializer.xml')->end()
//                ->end()
//            ->end();
//
        return $treeBuilder;
    }
}

#jms_serializer:
#    metadata:
#        directories:
#            kreta-comment:
#                namespace_prefix: "Kreta\\Component\\Comment"
#                path: "@KretaApiBundle/Resources/config/serializer"
#            kreta-core:
#                namespace_prefix: "Kreta\\Component\\Core"
#                path: "@KretaApiBundle/Resources/config/serializer"
#            kreta-issue:
#                namespace_prefix: "Kreta\\Component\\Issue"
#                path: "@KretaApiBundle/Resources/config/serializer"
#            kreta-media:
#                namespace_prefix: "Kreta\\Component\\Media"
#                path: "@KretaApiBundle/Resources/config/serializer"
#            kreta-notification:
#                namespace_prefix: "Kreta\\Component\\Notification"
#                path: "@KretaApiBundle/Resources/config/serializer"
#            kreta-project:
#                namespace_prefix: "Kreta\\Component\\Project"
#                path: "@KretaApiBundle/Resources/config/serializer"
#            kreta-user:
#                namespace_prefix: "Kreta\\Component\\User"
#                path: "@KretaApiBundle/Resources/config/serializer"
#            kreta-workflow:
#                namespace_prefix: "Kreta\\Component\\Workflow"
#                path: "@KretaApiBundle/Resources/config/serializer"
#            FOSUserBundle:
#                namespace_prefix: "FOS\\UserBundle"
#                path: "@KretaApiBundle/Resources/FOSUserBundle/serializer"
