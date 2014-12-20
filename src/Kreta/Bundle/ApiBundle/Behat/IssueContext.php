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
 * Class IssueContext.
 *
 * @package Kreta\Bundle\ApiBundle\Behat
 */
class IssueContext extends RawMinkContext implements Context, KernelAwareContext
{
    use KernelDictionary;

    /**
     * Populates the database with statuses.
     *
     * @param \Behat\Gherkin\Node\TableNode $issues The issues
     *
     * @return void
     *
     * @Given /^the following issues exist:$/
     */
    public function theFollowingIssuesExist(TableNode $issues)
    {
        $container = $this->kernel->getContainer();
        $manager = $container->get('doctrine')->getManager();

        foreach ($issues as $issueData) {
            $project = $container->get('kreta_project.repository.project')
                ->findOneBy(['name' => $issueData['project']]);
            $reporter = $container->get('kreta_user.repository.user')
                ->findOneBy(['email' => $issueData['reporter']]);
            $assignee = $container->get('kreta_user.repository.user')
                ->findOneBy(['email' => $issueData['assignee']]);
            $status = $container->get('kreta_workflow.repository.status')
                ->findOneBy(['name' => $issueData['status']]);

            $issue = $container->get('kreta_issue.factory.issue')->create($project, $reporter);
            $issue->setNumericId($issueData['numericId']);
            $issue->setCreatedAt(new \DateTime($issueData['createdAt']));
            $issue->setPriority($issueData['priority']);
            $issue->setProject($project);
            $issue->setAssignee($assignee);
            $issue->setReporter($reporter);
            $issue->setStatus($status);
            $issue->setType($issueData['type']);
            $issue->setTitle($issueData['title']);
            $issue->setDescription($issueData['description']);

            $metadata = $manager->getClassMetaData(get_class($issue));
            $metadata->setIdGenerator(new \Doctrine\ORM\Id\AssignedGenerator());
            $metadata->setIdentifierValues($issue, ['id' => $issueData['id']]);

            $manager->persist($issue);
        }

        $manager->flush();
    }
}
