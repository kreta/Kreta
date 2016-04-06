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

namespace Kreta\Bundle\WorkflowBundle\Behat\Context;

use Behat\Gherkin\Node\TableNode;
use Kreta\Bundle\CoreBundle\Behat\Context\DefaultContext;

/**
 * Class WorkflowContext.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
 */
class WorkflowContext extends DefaultContext
{
    /**
     * Populates the database with workflows.
     *
     * @param \Behat\Gherkin\Node\TableNode $workflows The workflows
     *
     *
     * @Given /^the following workflows exist:$/
     */
    public function theFollowingWorkflowsExist(TableNode $workflows)
    {
        foreach ($workflows as $workflowData) {
            $creator = $this->get('kreta_user.repository.user')
                ->findOneBy(['email' => $workflowData['creator']], false);
            $workflow = $this->get('kreta_workflow.factory.workflow')
                ->create($workflowData['name'], $creator);
            $this->setId($workflow, $workflowData['id']);
            if (isset($workflowData['createdAt'])) {
                $this->setField($workflow, 'createdAt', new \DateTime($workflowData['createdAt']));
            }

            $this->get('kreta_workflow.repository.workflow')->persist($workflow);
        }
    }
}
