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
 * Class StatusContext.
 *
 * @package Kreta\Bundle\WorkflowBundle\Behat
 */
class StatusContext extends DefaultContext
{
    /**
     * Populates the database with statuses.
     *
     * @param \Behat\Gherkin\Node\TableNode $statuses The statuses
     *
     * @return void
     *
     * @Given /^the following statuses exist:$/
     */
    public function theFollowingStatusesExist(TableNode $statuses)
    {
        $this->getManager();
        foreach ($statuses as $statusData) {
            $workflow = $this->getContainer()->get('kreta_workflow.repository.workflow')
                ->findOneBy(['name' => $statusData['workflow']]);

            $status = $this->getContainer()->get('kreta_workflow.factory.status')
                ->create($statusData['name'], $workflow);
            $status->setColor($statusData['color']);
            $status->setName($statusData['name']);
            $this->setId($status, $statusData['id']);

            $this->manager->persist($status);
        }

        $this->manager->flush();
    }
}
