<?php

/**
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
 * Class ProjectContext.
 *
 * @package Kreta\Bundle\ProjectBundle\Behat
 */
class ProjectContext extends DefaultContext
{
    /**
     * Populates the database with projects.
     *
     * @param \Behat\Gherkin\Node\TableNode $projects The projects
     *
     * @return void
     *
     * @Given /^the following projects exist:$/
     */
    public function theFollowingProjectsExist(TableNode $projects)
    {
        $this->getManager();
        foreach ($projects as $projectData) {
            if (isset($projectData['workflow'])) {
                $workflow = $this->getContainer()->get('kreta_workflow.repository.workflow')->findOneBy(
                    ['name' => $projectData['workflow']]
                );
                $project = $this->getContainer()->get('kreta_project.factory.project')
                    ->create($workflow->getCreator(), $workflow);
            } else {
                $creator = $this->getContainer()->get('kreta_user.repository.user')->findOneBy(
                    ['email' => $projectData['creator']]
                );
                $project = $this->getContainer()->get('kreta_project.factory.project')->create($creator);
            }
            $project->setName($projectData['name']);
            $project->setShortName($projectData['shortName']);
            if (isset($projectData['id'])) {
                $this->setId($project, $projectData['id']);
            }

            $this->manager->persist($project);
        }

        $this->manager->flush();
    }
}
