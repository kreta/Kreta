<?php

/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Bundle\FixturesBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Kreta\Bundle\FixturesBundle\DataFixtures\DataFixtures;

/**
 * Class LoadLabelData.
 *
 * @package Kreta\Bundle\FixturesBundle\DataFixtures\ORM
 */
class LoadLabelData extends DataFixtures
{
    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $tags = [
            'php', 'backend', 'server', 'configuration', 'frontend', 'symfony', 'angular.js', 'design', 'ux', 'sass',
            'marketing', 'commercial', 'social-network', 'foundation', 'ci', 'deploy', 'node.js', 'javascript', 'behat',
            'database', 'performance', 'cache', 'redis', 'mongodb', 'sphinx', 'twig', 'doctrine', 'bdd', 'testing',
            'phpspec', 'quality-assurance', 'clean-code', 'refactoring', 'backbone.js', 'nginx', 'memcached', 'compass'
        ];

        $projects = $this->container->get('kreta_project.repository.project')->findAll();

        foreach ($tags as $tag) {
            $label = $this->container->get('kreta_project.factory.label')
                ->create($projects[array_rand($projects)], $tag);

            $manager->persist($label);
        }

        $manager->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return 2;
    }
}
