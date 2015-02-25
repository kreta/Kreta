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
        foreach ($projects as $projectData) {
            if (isset($projectData['workflow'])) {
                $workflow = $this->get('kreta_workflow.repository.workflow')
                    ->findOneBy(['name' => $projectData['workflow']], false);
                $project = $this->get('kreta_project.factory.project')->create($workflow->getCreator(), $workflow);
            } else {
                $creator = $this->get('kreta_user.repository.user')
                    ->findOneBy(['email' => $projectData['creator']], false);
                $project = $this->get('kreta_project.factory.project')->create($creator);
            }
            $project
                ->setName($projectData['name'])
                ->setShortName($projectData['shortName']);
            if (isset($projectData['id'])) {
                $this->setId($project, $projectData['id']);
            }

            $this->get('kreta_project.repository.project')->persist($project);
        }
    }
}
