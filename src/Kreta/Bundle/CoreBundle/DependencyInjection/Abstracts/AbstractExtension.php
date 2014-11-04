<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Bundle\CoreBundle\DependencyInjection\Abstracts;

use Symfony\Bundle\FrameworkBundle\DependencyInjection\Configuration;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * Class AbstractExtension.
 *
 * @package Kreta\Bundle\CoreBundle\DependencyInjection\Abstracts
 */
class AbstractExtension extends Extension
{
    /**
     * Gets array with all the config file names.
     *
     * @param string $config The config
     *
     * @return array
     */
    protected function getConfigFiles($config)
    {
        return array('services', 'factories');
    }

    /**
     * Get the Config file location.
     *
     * @return string
     */
    protected function getConfigFilesLocation()
    {
        return __DIR__ . '/../../Resources/config';
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
                    if (isset($configFile[1]) && $configFile[1] === false) {
                        continue;
                    }
                    $configFile = $configFile[0];
                }
                $loader->load($configFile . '.yml');
            }
        }
    }
}
