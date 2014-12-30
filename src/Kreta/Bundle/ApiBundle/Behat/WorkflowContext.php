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
 * Class WorkflowContext.
 *
 * @package Kreta\Bundle\ApiBundle\Behat
 */
class WorkflowContext extends AbstractContext
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
        $manager = $this->getContainer()->get('doctrine')->getManager();

        foreach ($workflows as $workflowData) {
            $creator = $this->getContainer()->get('kreta_user.repository.user')
                ->findOneBy(['email' => $workflowData['creator']]);
            $workflow = $this->getContainer()->get('kreta_workflow.factory.workflow')
                ->create($workflowData['name'], $creator);

            $metadata = $manager->getClassMetaData(get_class($workflow));
            $metadata->setIdGenerator(new \Doctrine\ORM\Id\AssignedGenerator());
            $metadata->setIdentifierValues($workflow, ['id' => $workflowData['id']]);
            if (isset($workflowData['createdAt'])) {
                $metadata->setFieldValue($workflow, 'createdAt', new \DateTime($workflowData['createdAt']));
            }

            $manager->persist($workflow);
        }

        $manager->flush();
    }
}
