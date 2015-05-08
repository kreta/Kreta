<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\HttpKernel\Kernel;

/**
 * Class AppKernel.
 */
class AppKernel extends Kernel
{
    /**
     * {@inheritdoc}
     */
    public function registerBundles()
    {
        $bundles = [
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),
            new Symfony\Bundle\MonologBundle\MonologBundle(),
            new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),

            new Bazinga\Bundle\HateoasBundle\BazingaHateoasBundle(),
            new Finite\Bundle\FiniteBundle\FiniteFiniteBundle(),
            new FOS\OAuthServerBundle\FOSOAuthServerBundle(),
            new FOS\RestBundle\FOSRestBundle(),
            new FOS\UserBundle\FOSUserBundle(),
            new Knp\Bundle\GaufretteBundle\KnpGaufretteBundle(),
            new JMS\SerializerBundle\JMSSerializerBundle(),
            new Liip\ImagineBundle\LiipImagineBundle(),
            new Nelmio\ApiDocBundle\NelmioApiDocBundle(),
            new Nelmio\CorsBundle\NelmioCorsBundle(),
            new Doctrine\Bundle\MigrationsBundle\DoctrineMigrationsBundle(),

            new Kreta\SimpleApiDocBundle\KretaSimpleApiDocBundle(),

            new Kreta\Bundle\CommentBundle\KretaCommentBundle(),
            new Kreta\Bundle\FixturesBundle\KretaFixturesBundle(),
            new Kreta\Bundle\CoreBundle\KretaCoreBundle(),
            new Kreta\Bundle\IssueBundle\KretaIssueBundle(),
            new Kreta\Bundle\MediaBundle\KretaMediaBundle(),
            new Kreta\Bundle\NotificationBundle\KretaNotificationBundle(),
            new Kreta\Bundle\ProjectBundle\KretaProjectBundle(),
            new Kreta\Bundle\TimeTrackingBundle\KretaTimeTrackingBundle(),
            new Kreta\Bundle\UserBundle\KretaUserBundle(),
            new Kreta\Bundle\WebBundle\KretaWebBundle(),
            new Kreta\Bundle\WorkflowBundle\KretaWorkflowBundle(),
            new Kreta\Bundle\VCSBundle\KretaVCSBundle(),
        ];

        if (in_array($this->getEnvironment(), ['dev', 'test'])) {
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
            $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();

            $bundles[] = new Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle();
        }

        return $bundles;
    }

    /**
     * {@inheritdoc}
     */
    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__ . '/config/config_' . $this->getEnvironment() . '.yml');
    }

    /**
     * {@inheritdoc}
     */
    public function getCacheDir()
    {
        $filename = '/dev/shm/symfony/cache/';

        if (in_array($this->environment, ['dev', 'test']) && file_exists($filename)) {
            return $filename . $this->environment;
        }

        return parent::getCacheDir();
    }

    /**
     * {@inheritdoc}
     */
    public function getLogDir()
    {
        $filename = '/dev/shm/symfony/logs/';

        if (in_array($this->environment, ['dev', 'test']) && file_exists($filename)) {
            return $filename . $this->environment;
        }

        return parent::getLogDir();
    }
}
