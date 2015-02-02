<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Bundle\CoreBundle\DependencyInjection;

use Kreta\Bundle\CoreBundle\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension as BaseExtension;

/**
 * Class Extension.
 *
 * @package Kreta\Bundle\CoreBundle\DependencyInjection
 */
class Extension extends BaseExtension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $this->processConfiguration($configuration, $configs);
        $path = $this->getConfigurationDirectoryPath();
        $loader = new YamlFileLoader($container, new FileLocator($path));
        $loader->loadFilesFromDirectory($path);
    }

    /**
     * Gets the path for configuration directories.
     *
     * @return string
     */
    protected function getConfigurationDirectoryPath()
    {
        $classPath = new \ReflectionClass($this);
        $nameSpaceDir = dirname($classPath->getFileName());
        return $nameSpaceDir . '/../Resources/config';
    }
}
