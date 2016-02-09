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
 * Class ProjectContext.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
 */
class ProjectContext extends DefaultContext
{
    /**
     * Populates the database with projects.
     *
     * @param \Behat\Gherkin\Node\TableNode $projects The projects
     *
     *
     * @Given /^the following projects exist:$/
     */
    public function theFollowingProjectsExist(TableNode $projects)
    {
        foreach ($projects as $projectData) {
            $organization = null;
            if (isset($projectData['organization'])) {
                $organization = $this->get('kreta_organization.repository.organization')
                    ->findOneBy(['name' => $projectData['organization']]);
            }

            if (isset($projectData['workflow'])) {
                $workflow = $this->get('kreta_workflow.repository.workflow')
                    ->findOneBy(['name' => $projectData['workflow']], false);
                $project = $this->get('kreta_project.factory.project')
                    ->create($workflow->getCreator(), $organization, $workflow, false);
            } else {
                $creator = $this->get('kreta_user.repository.user')
                    ->findOneBy(['email' => $projectData['creator']], false);
                $project = $this->get('kreta_project.factory.project')
                    ->create($creator, $organization, null, false);
            }
            $project->setName($projectData['name']);
            if (isset($projectData['id'])) {
                $this->setId($project, $projectData['id']);
            }

            $this->get('kreta_project.repository.project')->persist($project);
        }
    }
}
