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
    private $participantRoles = ['ROLE_ADMIN', 'ROLE_PARTICIPANT'];

    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $projects = $this->container->get('kreta_project.repository.project')->findAll();
        $users = $this->container->get('kreta_user.repository.user')->findAll();

        foreach ($users as $user) {
            foreach ($projects as $project) {
                if (rand(0, 2) === 1) {
                    if(!$project->getUserRole($user)) { //Avoids adding existing participant
                        $participant = $this->container->get('kreta_project.factory.participant')
                            ->create($project, $user);
                        $participant->setRole($this->participantRoles[array_rand($this->participantRoles)]);
                        $manager->persist($participant);
                    }
                }
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
