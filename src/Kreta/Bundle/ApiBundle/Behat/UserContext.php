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
 * Class UserContext.
 *
 * @package Kreta\Bundle\ApiBundle\Behat
 */
class UserContext extends AbstractContext
{
    /**
     * Populates the database with users.
     *
     * @param \Behat\Gherkin\Node\TableNode $users The users
     *
     * @return void
     *
     * @Given /^the following users exist:$/
     */
    public function theFollowingUsersExist(TableNode $users)
    {
        $manager = $this->getContainer()->get('doctrine')->getManager();

        foreach ($users as $userData) {
            $user = $this->getContainer()->get('kreta_user.factory.user')->create();
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
