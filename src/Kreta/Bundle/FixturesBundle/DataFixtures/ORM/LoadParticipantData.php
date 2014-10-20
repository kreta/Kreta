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
 * Class LoadParticipantData.
 *
 * @package Kreta\Bundle\FixturesBundle\DataFixtures\ORM
 */
class LoadParticipantData extends DataFixtures
{
    /**
     * Array that contains all the project roles that supports the project.
     *
     * @var string[]
     */
    private $projectParticipants = array('ROLE_ADMIN', 'ROLE_PARTICIPANT');

    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $projects = $this->container->get('kreta_core.repository_project')->findAll();
        $users = $this->container->get('kreta_core.repository_user')->findAll();

        foreach ($users as $user) {
            $i = rand(0, count($projects) - 5);
            $userProjects = array($projects[$i], $projects[$i + 1], $projects[$i + 2], $projects[$i + 3]);
            foreach ($userProjects as $project) {
                $projectParticipant = $this->container->get('kreta_core.factory_participant')->create($project, $user);
                $projectParticipant->setRole($this->projectParticipants[array_rand($this->projectParticipants)]);

                $manager->persist($projectParticipant);
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
