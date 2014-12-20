<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Bundle\UserBundle\Behat;

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use Behat\MinkExtension\Context\RawMinkContext;
use Behat\Symfony2Extension\Context\KernelAwareContext;
use Behat\Symfony2Extension\Context\KernelDictionary;

/**
 * Class UserContext.
 *
 * @package Kreta\Bundle\UserBundle\Behat
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
            $user = $this->kernel->getContainer()->get('kreta_user.factory.user')->create();
            $user->setFirstname($userData['firstName']);
            $user->setLastname($userData['lastName']);
            $user->setEmail($userData['email']);
            $user->setPlainPassword($userData['password']);
            $user->setEnabled(true);
            $manager->persist($user);
        }

        $manager->flush();
    }
}
