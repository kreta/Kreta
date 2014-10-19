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

class StatusContext extends RawMinkContext implements Context, KernelAwareContext
{
    use KernelDictionary;

    /**
     * @Given /^the following statuses exist:$/
     */
    public function theFollowingStatusesExist(TableNode $statuses)
    {
        $manager = $this->kernel->getContainer()->get('doctrine')->getManager();

        foreach($statuses as $statusData) {
            /** @var \Kreta\Component\Core\Model\Interfaces\StatusInterface $status */
            $status = $this->kernel->getContainer()->get('kreta_core.factory_status')->create();
            $status->setDescription($statusData['description']);
            $manager->persist($status);
        }
        $manager->flush();
    }
}
