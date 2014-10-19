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

class ProjectContext extends RawMinkContext implements Context, KernelAwareContext
{
    use KernelDictionary;

    /**
     * @Given /^the following projects exist:$/
     */
    public function theFollowingStatusesExist(TableNode $projects)
    {
        $manager = $this->kernel->getContainer()->get('doctrine')->getManager();

        foreach($projects as $projectData) {
            /** @var \Kreta\Component\Core\Model\Interfaces\ProjectInterface $project */
            $project = $this->kernel->getContainer()->get('kreta_core.factory_project')->create();
            $project->setName($projectData['name']);

            $manager->persist($project);
        }
        $manager->flush();
    }
}
