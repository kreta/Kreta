<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Bundle\Api\ApiCoreBundle\Behat;

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use Behat\MinkExtension\Context\RawMinkContext;
use Behat\Symfony2Extension\Context\KernelAwareContext;
use Behat\Symfony2Extension\Context\KernelDictionary;

/**
 * Class ProjectContext.
 *
 * @package Kreta\Bundle\Api\ApiCoreBundle\Behat
 */
class ProjectContext extends RawMinkContext implements Context, KernelAwareContext
{
    use KernelDictionary;

    /**
     * @Given /^the following projects exist:$/
     */
    public function theFollowingProjectsExist(TableNode $projects)
    {
        $manager = $this->kernel->getContainer()->get('doctrine')->getManager();

        foreach($projects as $projectData) {
            $creator = $this->kernel->getContainer()->get('kreta_core.repository.user')->findOneBy(
                ['email' => $projectData['creator']]
            );
            $project = $this->kernel->getContainer()->get('kreta_core.factory.project')->create($creator);
            $project->setId($projectData['id']);
            $project->setName($projectData['name']);
            $project->setShortName($projectData['shortName']);

            $metadata = $manager->getClassMetaData(get_class($project));
            $metadata->setIdGenerator(new \Doctrine\ORM\Id\AssignedGenerator());

            $manager->persist($project);
        }

        $manager->flush();
    }
}
