<?php

/**
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
 * Class LoadProjectData.
 *
 * @package Kreta\Bundle\FixturesBundle\DataFixtures\ORM
 */
class LoadProjectData extends DataFixtures
{
    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $users = $this->container->get('kreta_core.repository_user')->findAll();

        for ($i = 0; $i < 100; $i++) {
            $project = $this->container->get('kreta_core.factory_project')->create();
            $project->setName('This is the project number ' . $i . ' that is created by fixtures');

            $this->loadRandomObjects($project, 'addParticipant', $users);

            $project->setShortName('PR-' . $i);

            $manager->persist($project);
        }

        $manager->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return 1;
    }
}
