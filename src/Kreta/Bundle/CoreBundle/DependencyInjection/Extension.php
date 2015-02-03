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
     * The current bundle's Configuration.php directory path.
     *
     * @var string
     */
    protected $directory;

    /**
     * The current bundle's Configuration.php namespace.
     *
     * @var string
     */
    protected $namespace;

    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $this->setUp();

        $configuration = new $this->namespace();
        $this->processConfiguration($configuration, $configs);

        $loader = new YamlFileLoader($container, new FileLocator($this->directory));
        $loader->loadFilesFromDirectory($this->directory);
    }

    /**
     * Sets the directory and namespace with the current bundle Extension data.
     *
     * @return void
     */
    protected function setUp()
    {
        $classPath = new \ReflectionClass($this);

        $this->directory = dirname($classPath->getFileName()) . '/../Resources/config';
        $this->namespace = $classPath->getNamespaceName() . '\Configuration';
    }
}
