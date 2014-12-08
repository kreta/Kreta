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
 * Class UserContext.
 *
 * @package Kreta\Bundle\Api\ApiCoreBundle\Behat
 */
class UserContext extends RawMinkContext implements Context, KernelAwareContext
{
    use KernelDictionary;

    /**
     * @Given /^the following users exist:$/
     */
    public function theFollowingUsersExist(TableNode $users)
    {
        $manager = $this->kernel->getContainer()->get('doctrine')->getManager();

        foreach ($users as $userData) {
            $user = $this->kernel->getContainer()->get('kreta_core.factory_user')->create();
            $user->setId($userData['id']);
            $user->setFirstname($userData['firstName']);
            $user->setLastname($userData['lastName']);
            $user->setCreatedAt(new \DateTime($userData['createdAt']));
            $user->setEmail($userData['email']);
            $user->setPlainPassword($userData['password']);
            $user->setEnabled(true);

            $metadata = $manager->getClassMetaData(get_class($user));
            $metadata->setIdGenerator(new \Doctrine\ORM\Id\AssignedGenerator());

            $manager->persist($user);
        }

        $manager->flush();
    }
}
