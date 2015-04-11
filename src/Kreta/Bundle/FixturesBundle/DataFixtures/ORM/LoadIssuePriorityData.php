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
 * Class LoadIssuePriorityData.
 *
 * @package Kreta\Bundle\FixturesBundle\DataFixtures\ORM
 */
class LoadIssuePriorityData extends DataFixtures
{
    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $priorities = ['Low', 'Medium', 'High', 'Blocker'];

        $projects = $this->container->get('kreta_project.repository.project')->findAll();

        foreach ($projects as $project) {
            foreach ($priorities as $name) {
                $issuePriority = $this->container->get('kreta_project.factory.issue_priority')->create($project, $name);

                $manager->persist($issuePriority);
            }
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
