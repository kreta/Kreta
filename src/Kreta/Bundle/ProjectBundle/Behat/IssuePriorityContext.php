<?php

/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Bundle\ProjectBundle\Behat;

use Behat\Gherkin\Node\TableNode;
use Kreta\Bundle\CoreBundle\Behat\DefaultContext;

/**
 * Class IssuePriorityContext.
 *
 * @package Kreta\Bundle\ProjectBundle\Behat
 */
class IssuePriorityContext extends DefaultContext
{
    /**
     * Populates the database with priorities.
     *
     * @param \Behat\Gherkin\Node\TableNode $issuePriorities The priorities
     *
     * @return void
     *
     * @Given /^the following issue priorities exist:$/
     */
    public function theFollowingIssuePrioritiesExist(TableNode $issuePriorities)
    {
        foreach ($issuePriorities as $priorityData) {
            $project = $this->get('kreta_project.repository.project')
                ->findOneBy(['name' => $priorityData['project']], false);

            $priority = $this->get('kreta_project.factory.issue_priority')->create($project, $priorityData['name']);

            if (isset($priorityData['id'])) {
                $this->setId($priority, $priorityData['id']);
            }

            $this->get('kreta_project.repository.issue_priority')->persist($priority);
        }
    }
}
