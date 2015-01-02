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

use Behat\Gherkin\Node\TableNode;
use Kreta\Bundle\CoreBundle\Behat\Abstracts\AbstractContext;

/**
 * Class ProjectContext.
 *
 * @package Kreta\Bundle\ApiBundle\Behat
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
            $workflow = $this->getContainer()->get('kreta_workflow.repository.workflow')->findOneBy(
                ['name' => $projectData['workflow']]
            );
            $project = $this->getContainer()->get('kreta_project.factory.project')
                ->create($workflow->getCreator(), $workflow);
            $project->setName($projectData['name']);
            $project->setShortName($projectData['shortName']);

            $metadata = $manager->getClassMetaData(get_class($project));
            $metadata->setIdGenerator(new \Doctrine\ORM\Id\AssignedGenerator());
            $metadata->setIdentifierValues($project, ['id' => $projectData['id']]);

            $manager->persist($project);
        }

        $manager->flush();
    }
}
