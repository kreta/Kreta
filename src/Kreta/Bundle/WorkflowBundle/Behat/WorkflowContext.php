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
use Kreta\Bundle\CoreBundle\Behat\Abstracts\AbstractContext;

/**
 * Class WorkflowContext.
 *
 * @package Kreta\Bundle\WorkflowBundle\Behat
 */
class WorkflowContext extends AbstractContext
{
    /**
     * Populates the database with workflows.
     *
     * @param \Behat\Gherkin\Node\TableNode $workflows The $workflows
     *
     * @return void
     *
     * @Given /^the following workflows exist:$/
     */
    public function theFollowingWorkflowsExist(TableNode $workflows)
    {
        $manager = $this->getContainer()->get('doctrine')->getManager();

        foreach ($workflows as $workflowData) {
            $creator = $this->getContainer()->get('kreta_user.repository.user')
                ->findOneBy(['email' => $workflowData['creator']]);
            $workflow = $this->getContainer()->get('kreta_workflow.factory.workflow')
                ->create($workflowData['name'], $creator);

            $manager->persist($workflow);
        }

        $manager->flush();
    }
}
