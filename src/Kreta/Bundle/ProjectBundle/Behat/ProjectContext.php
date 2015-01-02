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
use Kreta\Bundle\CoreBundle\Behat\Abstracts\AbstractContext;

/**
 * Class ProjectContext.
 *
 * @package Kreta\Bundle\ProjectBundle\Behat
 */
class ProjectContext extends AbstractContext
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
        $manager = $this->getContainer()->get('doctrine')->getManager();

        foreach ($projects as $projectData) {
            $creator = $this->getContainer()->get('kreta_user.repository.user')->findOneBy(
                ['email' => $projectData['creator']]
            );
            $project = $this->getContainer()->get('kreta_project.factory.project')->create($creator);
            $project->setName($projectData['name']);
            $project->setShortName($projectData['shortName']);

            $manager->persist($project);
        }

        $manager->flush();
    }
}
