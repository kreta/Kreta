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
     * @var string $nameSpaceDir
     */
    protected $nameSpaceDir;

    /**
     * @var string $nameSpace
     */
    protected $nameSpace;

    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $this->configureNamespacesAndPaths();
        $configClass = $this->getConfigurationClassPath();
        $configuration = new $configClass();
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
        return $this->nameSpaceDir . '/../Resources/config';
    }

    /**
     * Gets the path for configuration class.
     *
     * @return string
     */
    protected function getConfigurationClassPath()
    {
        return $this->nameSpace . '\Configuration';
    }

    /**
     * @return void
     */
    protected function configureNamespacesAndPaths()
    {
        $classPath = new \ReflectionClass($this);
        $this->nameSpaceDir = dirname($classPath->getFileName());
        $this->nameSpace = $classPath->getNamespaceName();
    }
}
