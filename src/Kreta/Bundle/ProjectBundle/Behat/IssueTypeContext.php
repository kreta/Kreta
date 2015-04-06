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
 * Class IssueTypeContext.
 *
 * @package Kreta\Bundle\ProjectBundle\Behat
 */
class IssueTypeContext extends DefaultContext
{
    /**
     * Populates the database with issue types.
     *
     * @param \Behat\Gherkin\Node\TableNode $issueTypes The issue types
     *
     * @return void
     *
     * @Given /^the following issue types exist:$/
     */
    public function theFollowingIssueTypesExist(TableNode $issueTypes)
    {
        foreach ($issueTypes as $issueTypeData) {
            $project = $this->get('kreta_project.repository.project')
                ->findOneBy(['name' => $issueTypeData['project']], false);

            $issueType = $this->get('kreta_project.factory.issue_type')->create($project, $issueTypeData['name']);

            if (isset($issueTypeData['id'])) {
                $this->setId($issueType, $issueTypeData['id']);
            }

            $this->get('kreta_project.repository.issue_type')->persist($issueType);
        }
    }
}
