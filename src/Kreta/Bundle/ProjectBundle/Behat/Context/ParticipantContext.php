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

namespace Kreta\Bundle\ProjectBundle\Behat\Context;

use Behat\Gherkin\Node\TableNode;
use Kreta\Bundle\CoreBundle\Behat\Context\DefaultContext;

/**
 * Class ParticipantContext.
 */
class ParticipantContext extends DefaultContext
{
    /**
     * Populates the database with participants.
     *
     * @param \Behat\Gherkin\Node\TableNode $participants The participants
     *
     *
     * @Given /^the following participants exist:$/
     */
    public function theFollowingParticipantsExist(TableNode $participants)
    {
        foreach ($participants as $participantData) {
            $project = $this->get('kreta_project.repository.project')
                ->findOneBy(['name' => $participantData['project']], false);
            $user = $this->get('kreta_user.repository.user')
                ->findOneBy(['email' => $participantData['user']], false);

            $participant = $this->get('kreta_project.factory.participant')->create($project, $user);
            $participant->setRole($participantData['role']);

            $this->get('kreta_project.repository.participant')->persist($participant);
        }
    }
}
