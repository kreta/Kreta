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

namespace Kreta\Bundle\CoreBundle\DependencyInjection;

use Kreta\Bundle\CoreBundle\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\DependencyInjection\Extension as BaseExtension;

/**
 * Class Extension.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
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
     */
    protected function setUp()
    {
        $classPath = new \ReflectionClass($this);

        $this->directory = dirname($classPath->getFileName()) . '/../Resources/config';
        $this->namespace = $classPath->getNamespaceName() . '\Configuration';
    }
}
