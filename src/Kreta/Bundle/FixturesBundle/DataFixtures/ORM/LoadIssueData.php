<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Bundle\FixturesBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Kreta\Bundle\FixturesBundle\DataFixtures\DataFixtures;
use Kreta\Component\Project\Model\Interfaces\ProjectInterface;

/**
 * Class LoadIssueData.
 *
 * @package Kreta\Bundle\FixturesBundle\DataFixtures\ORM
 */
class LoadIssueData extends DataFixtures
{
    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $labels = $this->container->get('kreta_issue.repository.label')->findAll();
        $projects = $this->container->get('kreta_project.repository.project')->findAll();
        $resolutions = $this->container->get('kreta_issue.repository.resolution')->findAll();

        $issuesPerProject = [];
        for ($i = 0; $i < 100; $i++) {
            $project = $projects[array_rand($projects)];
            $issuesPerProject = $this->incrementIssuePerProject($issuesPerProject, $project);
            $participants = $this->container->get('kreta_project.repository.participant')
                ->findBy(['project' => $project]);

            $issue = $this->container->get('kreta_issue.factory.issue')
                ->create($project, $participants[array_rand($participants)]->getUser());
            $issue->setAssignee($participants[array_rand($participants)]->getUser());
            $issue->setDescription(
                'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean
                massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec
                quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec
                pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a,
                venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus.
                Vivamus elementum semper nisi. Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu,
                consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus.
                Phasellus viverra nulla ut metus varius laoreet. Quisque rutrum. Aenean imperdiet. Etiam ultricies nisi
                vel augue. Curabitur ullamcorper ultricies nisi. Nam eget dui. Etiam rhoncus. Maecenas tempus, tellus
                eget condimentum rhoncus, sem quam semper libero, sit amet adipiscing sem neque sed ipsum. Nam quam
                nunc, blandit vel, luctus pulvinar, hendrerit id, lorem. Maecenas nec odio et ante tincidunt tempus.
                Donec vitae sapien ut libero venenatis faucibus. Nullam quis ante. Etiam sit amet orci eget eros
                faucibus tincidunt. Duis leo. Sed fringilla mauris sit amet nibh. Donec sodales sagittis magna. Sed
                consequat, leo eget bibendum sodales, augue velit cursus nunc'
            );
            $this->loadRandomObjects($issue, 'addLabel', $labels, count($labels));
            $issue->setNumericId($issuesPerProject[$project->getShortName()]);
            $issue->setPriority(rand(0, 3));
            if ($i % 5 !== 0) {
                $issue->setResolution($resolutions[array_rand($resolutions)]);
            }
            $issue->setReporter($participants[array_rand($participants)]->getUser());
            $statuses = $this->container->get('kreta_workflow.repository.status')
                ->findBy(['workflow' => $project->getWorkflow()]);
            $status = $statuses[array_rand($statuses)];
            $issue->setStatus($status);
            $types = [
                $issue::TYPE_BUG,
                $issue::TYPE_NEW_FEATURE,
                $issue::TYPE_IMPROVEMENT,
                $issue::TYPE_EPIC,
                $issue::TYPE_STORY
            ];
            $issue->setType($types[array_rand($types)]);
            $issue->setTitle('Issue - ' . $i);

            $users = [];
            foreach ($participants as $participant) {
                $users[] = $participant->getUser();
            }
            $this->loadRandomObjects($issue, 'addWatcher', $users);

            $this->addReference('issue-' . $i, $issue);

            $manager->persist($issue);
        }

        $manager->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return 3;
    }

    /**
     * Increments the counter of issues of index of project given. It creates the project index if is not exist yet.
     *
     * @param array                                                      $issuesPerProject Array that counts
     *                                                                                     issues per project
     * @param \Kreta\Component\Project\Model\Interfaces\ProjectInterface $project          The project
     *
     * @return array
     */
    private function incrementIssuePerProject(array $issuesPerProject, ProjectInterface $project)
    {
        foreach ($issuesPerProject as $projectShortName => $amount) {
            if ($projectShortName === $project->getShortName()) {
                $issuesPerProject[$projectShortName] = $amount + 1;

                return $issuesPerProject;
            }
        }

        $issuesPerProject[$project->getShortName()] = 1;

        return $issuesPerProject;
    }
}
