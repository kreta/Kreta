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

namespace Kreta\Bundle\ProjectBundle\Behat\Context;

use Behat\Gherkin\Node\TableNode;
use Kreta\Bundle\CoreBundle\Behat\Context\DefaultContext;

/**
 * Class IssuePriorityContext.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
 */
class IssuePriorityContext extends DefaultContext
{
    /**
     * Populates the database with priorities.
     *
     * @param \Behat\Gherkin\Node\TableNode $issuePriorities The priorities
     *
     * @Given /^the following issue priorities exist:$/
     */
    public function theFollowingIssuePrioritiesExist(TableNode $issuePriorities)
    {
        foreach ($issuePriorities as $priorityData) {
            $project = $this->get('kreta_project.repository.project')
                ->findOneBy(['name' => $priorityData['project']], false);

            $priority = $this->get('kreta_project.factory.issue_priority')->create(
                $project, $priorityData['name'], $priorityData['color']
            );

            if (isset($priorityData['id'])) {
                $this->setId($priority, $priorityData['id']);
            }

            $this->get('kreta_project.repository.issue_priority')->persist($priority);
        }
    }
}
