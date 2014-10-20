<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Bundle\CoreBundle\Behat;

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use Behat\MinkExtension\Context\RawMinkContext;
use Behat\Symfony2Extension\Context\KernelAwareContext;
use Behat\Symfony2Extension\Context\KernelDictionary;

/**
 * Class ParticipantContext.
 *
 * @package Kreta\Bundle\CoreBundle\Behat
 */
class ParticipantContext extends RawMinkContext implements Context, KernelAwareContext
{
    use KernelDictionary;

    /**
     * @Given /^the following participants exist:$/
     */
    public function theFollowingParticipantsExist(TableNode $participants)
    {
        $manager = $this->getContainer()->get('doctrine')->getManager();

        foreach($participants as $participantData) {
            $project = $this->getContainer()->get('kreta_core.repository_project')->findOneBy(
                array('name' => $participantData['project'])
            );
            $user = $this->getContainer()->get('kreta_core.repository_user')->findOneBy(
                array('email' => $participantData['user'])
            );

            $participant = $this->getContainer()->get('kreta_core.factory_participant')->create($project, $user);

            $participant->setRole($participantData['role']);

            $manager->persist($participant);
        }

        $manager->flush();
    }
}
