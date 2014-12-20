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

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use Behat\MinkExtension\Context\RawMinkContext;
use Behat\Symfony2Extension\Context\KernelAwareContext;
use Behat\Symfony2Extension\Context\KernelDictionary;

/**
 * Class StatusContext.
 *
 * @package Kreta\Bundle\WorkflowBundle\Behat
 */
class StatusContext extends RawMinkContext implements Context, KernelAwareContext
{
    use KernelDictionary;

    /**
     * @Given /^the following statuses exist:$/
     */
    public function theFollowingStatusesExist(TableNode $statuses)
    {
        $manager = $this->kernel->getContainer()->get('doctrine')->getManager();

        foreach ($statuses as $statusData) {
            $workflow = $this->getKernel()->getContainer()->get('kreta_workflow.repository.workflow')
                ->findOneBy(['name' => $statusData['workflow']]);

            $status = $this->kernel->getContainer()->get('kreta_workflow.factory.status')->create($statusData['name']);
            $status->setColor($statusData['color']);
            $status->setWorkflow($workflow);
            $manager->persist($status);
        }

        $manager->flush();
    }
}
