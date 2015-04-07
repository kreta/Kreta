<?php

/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Bundle\WorkflowBundle\Behat;

use Behat\Gherkin\Node\TableNode;
use Kreta\Bundle\CoreBundle\Behat\DefaultContext;

/**
 * Class StatusTransitionContext.
 *
 * @package Kreta\Bundle\WorkflowBundle\Behat
 */
class StatusTransitionContext extends DefaultContext
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
        foreach ($statusTransitions as $transitionData) {
            $initials = [];
            $initialNames = explode(',', $transitionData['initialStates']);
            foreach ($initialNames as $initialName) {
                $initials[] = $this->get('kreta_workflow.repository.status')
                    ->findOneBy(['name' => $initialName], false);
            }
            $status = $this->get('kreta_workflow.repository.status')
                ->findOneBy(['name' => $transitionData['status']], false);

            $transition = $this->get('kreta_workflow.factory.status_transition')
                ->create($transitionData['name'], $status, $initials);
            $this->setId($transition, $transitionData['id']);

            $this->get('kreta_workflow.repository.status_transition')->persist($transition);
        }
    }
}
