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

namespace Kreta\Bundle\IssueBundle\Behat\Context;

use Behat\Gherkin\Node\TableNode;
use Kreta\Bundle\CoreBundle\Behat\Context\DefaultContext;

/**
 * Class IssueContext.
 */
class IssueContext extends DefaultContext
{
    /**
     * Populates the database with issues.
     *
     * @param \Behat\Gherkin\Node\TableNode $issues The issues
     *
     *
     * @Given /^the following issues exist:$/
     */
    public function theFollowingIssuesExist(TableNode $issues)
    {
        foreach ($issues as $issueData) {
            $reporter = $this->get('kreta_user.repository.user')->findOneBy(['email' => $issueData['reporter']], false);
            $assignee = $this->get('kreta_user.repository.user')->findOneBy(['email' => $issueData['assignee']], false);
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

            $issue = $this->get('kreta_issue.factory.issue')->create($reporter, $priority, $project);
            $issue
                ->setAssignee($assignee)
                ->setStatus($status)
                ->setTitle($issueData['title'])
                ->setDescription($issueData['description']);

            if (isset($issueData['parent']) && $issueData['parent']) {
                $parent = $this->get('kreta_issue.repository.issue')->find($issueData['parent'], false);
                $issue->setParent($parent);
            }

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
