<?php

/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Bundle\IssueBundle\Behat;

use Behat\Gherkin\Node\TableNode;
use Kreta\Bundle\CoreBundle\Behat\DefaultContext;

/**
 * Class IssueContext.
 *
 * @package Kreta\Bundle\IssueBundle\Behat
 */
class IssueContext extends DefaultContext
{
    /**
     * Populates the database with issues.
     *
     * @param \Behat\Gherkin\Node\TableNode $issues The issues
     *
     * @return void
     *
     * @Given /^the following issues exist:$/
     */
    public function theFollowingIssuesExist(TableNode $issues)
    {
        foreach ($issues as $issueData) {
            $reporter = $this->get('kreta_user.repository.user')->findOneBy(['email' => $issueData['reporter']], false);
            $assignee = $this->get('kreta_user.repository.user')->findOneBy(['email' => $issueData['assignee']], false);
            $type = $this->get('kreta_project.repository.issue_type')->find($issueData['type'], false);
            $priority = $this->get('kreta_project.repository.issue_priority')->find($issueData['priority'], false);
            $project = $this->get('kreta_project.repository.project')
                ->findOneBy(['name' => $issueData['project']], false);
            $status = $this->get('kreta_workflow.repository.status')
                ->findOneBy(['name' => $issueData['status']], false);
            $labels = [];
            if (isset($issueData['labels'])) {
                foreach (explode(',', $issueData['labels']) as $labelName) {
                    $labels[] = $this->get('kreta_project.repository.label')->findOneBy(['name' => $labelName]);
                }
            }

            $issue = $this->get('kreta_issue.factory.issue')->create($reporter, $type, $priority, $project);
            $issue
                ->setAssignee($assignee)
                ->setStatus($status)
                ->setTitle($issueData['title'])
                ->setDescription($issueData['description']);

            $this->setField($issue, 'labels', $labels);
            if (isset($issueData['numericId'])) {
                $this->setField($issue, 'numericId', $issueData['numericId']);
            }
            if (isset($issueData['createdAt'])) {
                $this->setField($issue, 'createdAt', new \DateTime($issueData['createdAt']));
            }
            if (isset($issueData['id'])) {
                $this->setId($issue, $issueData['id']);
            }

            $this->get('kreta_issue.repository.issue')->persist($issue);
        }
    }
}
