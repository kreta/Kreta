<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Bundle\IssueBundle\Behat;

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use Behat\MinkExtension\Context\RawMinkContext;
use Behat\Symfony2Extension\Context\KernelAwareContext;
use Behat\Symfony2Extension\Context\KernelDictionary;

/**
 * Class IssueContext.
 *
 * @package Kreta\Bundle\IssueBundle\Behat
 */
class IssueContext extends RawMinkContext implements Context, KernelAwareContext
{
    use KernelDictionary;

    /**
     * @Given /^the following issues exist:$/
     */
    public function theFollowingStatusesExist(TableNode $issues)
    {
        $manager = $this->kernel->getContainer()->get('doctrine')->getManager();

        foreach ($issues as $issueData) {
            $project = $this->getKernel()->getContainer()->get('kreta_project.repository.project')
                ->findOneBy(['name' => $issueData['project']]);
            $reporter = $this->getKernel()->getContainer()->get('kreta_user.repository.user')
                ->findOneBy(['email' => $issueData['reporter']]);
            $assignee = $this->getKernel()->getContainer()->get('kreta_user.repository.user')
                ->findOneBy(['email' => $issueData['assignee']]);
            $status = $this->getKernel()->getContainer()->get('kreta_workflow.repository.status')
                ->findOneBy(['name' => $issueData['status']]);

            $issue = $this->kernel->getContainer()->get('kreta_issue.factory.issue')->create($project, $reporter);
            $issue->setPriority($issueData['priority']);
            $issue->setProject($project);
            $issue->setAssignee($assignee);
            $issue->setReporter($reporter);
            $issue->setStatus($status);
            $issue->setType($issueData['type']);
            $issue->setTitle($issueData['title']);
            $issue->setDescription($issueData['description']);

            $manager->persist($issue);
        }

        $manager->flush();
    }
}
