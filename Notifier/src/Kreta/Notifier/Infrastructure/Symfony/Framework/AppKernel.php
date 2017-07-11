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

declare(strict_types=1);

namespace Kreta\Notifier\Infrastructure\Symfony\Framework;

use Http\HttplugBundle\HttplugBundle;
use Nelmio\CorsBundle\NelmioCorsBundle;
use OldSound\RabbitMqBundle\OldSoundRabbitMqBundle;
use PSS\SymfonyMockerContainer\DependencyInjection\MockerContainer;
use SimpleBus\SymfonyBridge\SimpleBusCommandBusBundle;
use SimpleBus\SymfonyBridge\SimpleBusEventBusBundle;
use Snc\RedisBundle\SncRedisBundle;
use Symfony\Bundle\DebugBundle\DebugBundle;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Bundle\MonologBundle\MonologBundle;
use Symfony\Bundle\SecurityBundle\SecurityBundle;
use Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle;
use Symfony\Bundle\TwigBundle\TwigBundle;
use Symfony\Bundle\WebProfilerBundle\WebProfilerBundle;
use Symfony\Bundle\WebServerBundle\WebServerBundle;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\HttpKernel\Kernel;
use Warezgibzzz\QueryBusBundle\WarezgibzzzQueryBusBundle;

class AppKernel extends Kernel
{
    public function registerBundles() : array
    {
        $bundles = [
            new FrameworkBundle(),
            new HttplugBundle(),
            new MonologBundle(),
            new NelmioCorsBundle(),
            new OldSoundRabbitMqBundle(),
            new SecurityBundle(),
            new SimpleBusCommandBusBundle(),
            new SimpleBusEventBusBundle(),
            new SncRedisBundle(),
            new SwiftmailerBundle(),
            new WarezgibzzzQueryBusBundle(),
        ];

        if (in_array($this->getEnvironment(), ['dev', 'test'], true)) {
            $bundles[] = new DebugBundle();

            if ('dev' === $this->getEnvironment()) {
                $bundles[] = new TwigBundle();
                $bundles[] = new WebProfilerBundle();
                $bundles[] = new WebServerBundle();
            }
        }

        return $bundles;
    }

    public function getRootDir() : string
    {
        return __DIR__;
    }

    public function getCacheDir() : string
    {
        return dirname(__DIR__) . '/../../../../../var/cache/' . $this->getEnvironment();
    }

    public function getLogDir() : string
    {
        return dirname(__DIR__) . '/../../../../../var/logs';
    }

    public function registerContainerConfiguration(LoaderInterface $loader) : void
    {
        $loader->load($this->getRootDir() . '/config/config_' . $this->getEnvironment() . '.yml');
    }

    protected function getContainerBaseClass() : string
    {
        if ('test' === $this->environment) {
            return MockerContainer::class;
        }

        return parent::getContainerBaseClass();
    }
}
