<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Bundle\CoreBundle\Behat;

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use Behat\MinkExtension\Context\RawMinkContext;
use Behat\Symfony2Extension\Context\KernelAwareContext;
use Behat\Symfony2Extension\Context\KernelDictionary;

/**
 * Class ProjectContext.
 *
 * @package Kreta\Bundle\CoreBundle\Behat
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
            $project = $this->kernel->getContainer()->get('kreta_core.factory_project')->create();
            $project->setName($projectData['name']);
            $project->setShortName($projectData['shortName']);

            $manager->persist($project);
        }

        $manager->flush();
    }
}
