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

namespace Kreta\IdentityAccess\Infrastructure\Symfony;

use BenGorUser\UserBundle\BenGorUserBundle;
use Doctrine\Bundle\DoctrineBundle\DoctrineBundle;
use Doctrine\Bundle\MigrationsBundle\DoctrineMigrationsBundle;
use JMS\SerializerBundle\JMSSerializerBundle;
use Lexik\Bundle\JWTAuthenticationBundle\LexikJWTAuthenticationBundle;
use OldSound\RabbitMqBundle\OldSoundRabbitMqBundle;
use Sensio\Bundle\DistributionBundle\SensioDistributionBundle;
use SimpleBus\AsynchronousBundle\SimpleBusAsynchronousBundle;
use SimpleBus\JMSSerializerBundleBridge\SimpleBusJMSSerializerBundleBridgeBundle;
use SimpleBus\RabbitMQBundleBridge\SimpleBusRabbitMQBundleBridgeBundle;
use SimpleBus\SymfonyBridge\DoctrineOrmBridgeBundle;
use SimpleBus\SymfonyBridge\SimpleBusCommandBusBundle;
use SimpleBus\SymfonyBridge\SimpleBusEventBusBundle;
use Symfony\Bundle\DebugBundle\DebugBundle;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Bundle\MonologBundle\MonologBundle;
use Symfony\Bundle\SecurityBundle\SecurityBundle;
use Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle;
use Symfony\Bundle\TwigBundle\TwigBundle;
use Symfony\Bundle\WebProfilerBundle\WebProfilerBundle;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\HttpKernel\Kernel;

class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = [
            new DoctrineBundle(),
            new DoctrineMigrationsBundle(),
            new FrameworkBundle(),
            new JMSSerializerBundle(),
            new LexikJWTAuthenticationBundle(),
            new MonologBundle(),
            new SecurityBundle(),
            new SwiftmailerBundle(),
            new TwigBundle(),

            new SimpleBusAsynchronousBundle(),
            new SimpleBusRabbitMQBundleBridgeBundle(),
//            new SimpleBusJMSSerializerBundleBridgeBundle(),
            new OldSoundRabbitMqBundle(),

            new \BenGorUser\TwigBridgeBundle\TwigBridgeBundle(),
            new \BenGorUser\SymfonyRoutingBridgeBundle\SymfonyRoutingBridgeBundle(),
            new \BenGorUser\SymfonySecurityBridgeBundle\SymfonySecurityBridgeBundle(),
            new \BenGorUser\SwiftMailerBridgeBundle\SwiftMailerBridgeBundle(),
            new \BenGorUser\DoctrineORMBridgeBundle\DoctrineORMBridgeBundle(),
            new \BenGorUser\SimpleBusBridgeBundle\SimpleBusBridgeBundle(),
            new \BenGorUser\SimpleBusBridgeBundle\SimpleBusDoctrineORMBridgeBundle(),
            new BenGorUserBundle(),

            new DoctrineOrmBridgeBundle(),
            new SimpleBusCommandBusBundle(),
            new SimpleBusEventBusBundle(),
        ];

        if (in_array($this->getEnvironment(), ['dev', 'test'], true)) {
            $bundles[] = new DebugBundle();
            $bundles[] = new SensioDistributionBundle();
            $bundles[] = new WebProfilerBundle();
        }

        return $bundles;
    }

    public function getRootDir()
    {
        return __DIR__;
    }

    public function getCacheDir()
    {
        return dirname(__DIR__) . '/../../var/cache/' . $this->getEnvironment();
    }

    public function getLogDir()
    {
        return dirname(__DIR__) . '/../../var/logs';
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load($this->getRootDir() . '/config/config_' . $this->getEnvironment() . '.yml');
    }
}
