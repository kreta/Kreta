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

namespace Kreta\Bundle\OrganizationBundle\Behat\Context;

use Behat\Gherkin\Node\TableNode;
use Kreta\Bundle\CoreBundle\Behat\Context\DefaultContext;

/**
 * Behat Participant context class.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 */
class ParticipantContext extends DefaultContext
{
    /**
     * Populates the database with participants.
     *
     * @param \Behat\Gherkin\Node\TableNode $participants The participants
     *
     * @Given /^the following organization participants exist:$/
     */
    public function theFollowingParticipantsExist(TableNode $participants)
    {
        foreach ($participants as $participantData) {
            $organization = $this->get('kreta_organization.repository.organization')
                ->findOneBy(['name' => $participantData['organization']], false);
            $user = $this->get('kreta_user.repository.user')
                ->findOneBy(['email' => $participantData['user']], false);

            $participant = $this->get('kreta_organization.factory.participant')->create($organization, $user);
            $participant->setRole($participantData['role']);

            $this->get('kreta_organization.repository.participant')->persist($participant);
        }
    }
}
