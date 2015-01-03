<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Bundle\ApiBundle\Behat;

use Behat\Gherkin\Node\TableNode;
use Kreta\Bundle\CoreBundle\Behat\Abstracts\AbstractContext;

/**
 * Class StatusTransitionContext.
 *
 * @package Kreta\Bundle\ApiBundle\Behat
 */
class StatusTransitionContext extends AbstractContext
{
    /**
     * Populates the database with status transitions.
     *
     * @param \Behat\Gherkin\Node\TableNode $statusTransitions The status transitions
     *
     * @return void
     *
     * @Given /^the following status transitions exist:$/
     */
    public function theFollowingStatusesExist(TableNode $statusTransitions)
    {
        $manager = $this->getContainer()->get('doctrine')->getManager();

        foreach ($statusTransitions as $transitionData) {
            $initials = [];
            $initialNames = explode(',', $transitionData['initialStates']);
            foreach ($initialNames as $initialName) {
                $initials[] = $this->getContainer()->get('kreta_workflow.repository.status')
                    ->findOneBy(['name' => $initialName]);
            }
            $status = $this->getContainer()->get('kreta_workflow.repository.status')
                ->findOneBy(['name' => $transitionData['status']]);

            $transition = $this->getContainer()->get('kreta_workflow.factory.status_transition')
                ->create($transitionData['name'], $status, $initials);

            $metadata = $manager->getClassMetaData(get_class($transition));
            $metadata->setIdGenerator(new \Doctrine\ORM\Id\AssignedGenerator());
            $metadata->setIdentifierValues($transition, ['id' => $transitionData['id']]);

            $manager->persist($transition);
        }

        $manager->flush();
    }
}
