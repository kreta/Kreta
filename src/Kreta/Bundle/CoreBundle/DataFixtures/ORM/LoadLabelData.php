<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Bundle\CoreBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Kreta\Bundle\CoreBundle\DataFixtures\DataFixtures;

/**
 * Class LoadLabelData.
 *
 * @package Kreta\Bundle\CoreBundle\DataFixtures\ORM
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
            'marketing', 'commercial', 'social-network', 'foundation', 'continuous-integration', 'deploy', 'node.js',
            'javascript', 'database', 'performance', 'cache', 'redis', 'mongodb', 'sphinx', 'twig', 'doctrine', 'bdd',
            'testing', 'behat', 'phpspec', 'quality-assurance', 'clean-code', 'refactoring'
        ];

        foreach ($tags as $tag) {
            $label = $this->container->get('kreta_core.factory_label')->create();
            $label->setName($tag);

            $manager->persist($label);
        }

        $manager->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return 0;
    }
}
