<?php

/**
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
 * Class WorkflowContext.
 *
 * @package Kreta\Bundle\WorkflowBundle\Behat
 */
class WorkflowContext extends DefaultContext
{
    /**
     * Populates the database with workflows.
     *
     * @param \Behat\Gherkin\Node\TableNode $workflows The workflows
     *
     * @return void
     *
     * @Given /^the following workflows exist:$/
     */
    public function theFollowingWorkflowsExist(TableNode $workflows)
    {
        $this->getManager();
        foreach ($workflows as $workflowData) {
            $creator = $this->getContainer()->get('kreta_user.repository.user')
                ->findOneBy(['email' => $workflowData['creator']]);
            $workflow = $this->getContainer()->get('kreta_workflow.factory.workflow')
                ->create($workflowData['name'], $creator);
            $this->setId($workflow, $workflowData['id']);
            if (isset($workflowData['createdAt'])) {
                $this->setField($workflow, 'createdAt', new \DateTime($workflowData['createdAt']));
            }

            $this->manager->persist($workflow);
        }

        $this->manager->flush();
    }
}
