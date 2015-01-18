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

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * Abstract class AbstractExtension.
 *
 * @package Kreta\Bundle\CoreBundle\DependencyInjection\Abstracts
 */
abstract class AbstractExtension extends Extension
{
    /**
     * Gets the Config file location.
     *
     * @return string
     */
    abstract protected function getConfigFilesLocation();

    /**
     * Gets the Configuration instance.
     *
     * @return string
     */
    abstract protected function getConfigurationInstance();

    /**
     * Gets array with all the config file names.
     *
     * @return string[]
     */
    protected function getConfigFiles()
    {
        return ['services'];
    }

    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = $this->getConfigurationInstance();
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
