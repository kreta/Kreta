<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Bundle\VCSBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * Class KretaVCSExtension.
 *
 * @package Kreta\Bundle\VCSBundle\DependencyInjection
 */
class KretaVCSExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    protected function getConfigFilesLocation()
    {
        return __DIR__ . '/../Resources/config';
    }

    /**
     * {@inheritdoc}
     */
    protected function getConfigFiles()
    {
        return [
            'factories',
            'listeners',
            'matchers',
            'parameters',
            'repositories',
            'serializers',
            'strategies',
            'subscribers'
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $configFiles = $this->getConfigFiles($config);

        if (!empty($configFiles)) {
            $loader = new Loader\YamlFileLoader($container, new FileLocator($this->getConfigFilesLocation()));
            foreach ($configFiles as $configFile) {
                if (is_array($configFile)) {
                    if (!isset($configFile[1]) && $configFile[1]) {
                        continue;
                    }
                    $configFile = $configFile[0];
                }
                $loader->load($configFile . '.yml');
            }
        }
    }
}
