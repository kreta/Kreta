<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Bundle\ProjectBundle\Behat;

use Behat\Gherkin\Node\TableNode;
use Kreta\Bundle\CoreBundle\Behat\DefaultContext;

/**
 * Class ParticipantContext.
 *
 * @package Kreta\Bundle\ProjectBundle\Behat
 */
class ParticipantContext extends DefaultContext
{
    /**
     * Populates the database with participants.
     *
     * @param \Behat\Gherkin\Node\TableNode $participants The participants
     *
     * @return void
     *
     * @Given /^the following participants exist:$/
     */
    public function theFollowingParticipantsExist(TableNode $participants)
    {
        $this->getManager();
        foreach ($participants as $participantData) {
            $project = $this->getContainer()->get('kreta_project.repository.project')->findOneBy(
                ['name' => $participantData['project']]
            );
            $user = $this->getContainer()->get('kreta_user.repository.user')->findOneBy(
                ['email' => $participantData['user']]
            );

            $participant = $this->getContainer()->get('kreta_project.factory.participant')->create($project, $user);

            $participant->setRole($participantData['role']);

            $this->manager->persist($participant);
        }

        $this->manager->flush();
    }
}
