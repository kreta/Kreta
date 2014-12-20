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
 * Class ProjectContext.
 *
 * @package Kreta\Bundle\ApiBundle\Behat
 */
class ProjectContext extends RawMinkContext implements Context, KernelAwareContext
{
    use KernelDictionary;

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
        $container = $this->kernel->getContainer();
        $manager = $container->get('doctrine')->getManager();

        foreach ($projects as $projectData) {
            $workflow = $container->get('kreta_workflow.repository.workflow')->findOneBy(
                ['name' => $projectData['workflow']]
            );
            $project = $container->get('kreta_project.factory.project')->create($workflow->getCreator(), $workflow);
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
