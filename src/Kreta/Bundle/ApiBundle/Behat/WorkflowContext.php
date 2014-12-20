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

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use Behat\MinkExtension\Context\RawMinkContext;
use Behat\Symfony2Extension\Context\KernelAwareContext;
use Behat\Symfony2Extension\Context\KernelDictionary;

/**
 * Class WorkflowContext.
 *
 * @package Kreta\Bundle\ApiBundle\Behat
 */
class WorkflowContext extends RawMinkContext implements Context, KernelAwareContext
{
    use KernelDictionary;

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
        $manager = $this->kernel->getContainer()->get('doctrine')->getManager();
        $container = $this->kernel->getContainer();

        foreach ($workflows as $workflowData) {
            $creator = $this->kernel->getContainer()->get('kreta_user.repository.user')->findOneBy(
                ['email' => $workflowData['creator']]
            );
            $workflow = $container->get('kreta_workflow.factory.workflow')->create($workflowData['name'], $creator);

            $metadata = $manager->getClassMetaData(get_class($workflow));
            $metadata->setIdGenerator(new \Doctrine\ORM\Id\AssignedGenerator());
            $metadata->setIdentifierValues($workflow, ['id' => $workflowData['id']]);

            $manager->persist($workflow);
        }

        $manager->flush();
    }
}
