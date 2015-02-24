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

use Behat\Gherkin\Node\TableNode;
use Kreta\Bundle\CoreBundle\Behat\DefaultContext;

/**
 * Class UserContext.
 *
 * @package Kreta\Bundle\UserBundle\Behat
 */
class UserContext extends DefaultContext
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
        foreach ($users as $userData) {
            $user = $this->get('kreta_user.factory.user')->create();
            $user
                ->setFirstname($userData['firstName'])
                ->setLastname($userData['lastName'])
                ->setEmail($userData['email'])
                ->setPlainPassword($userData['password'])
                ->setEnabled(true);

            if (isset($userData['createdAt'])) {
                $this->setField($user, 'createdAt', new \DateTime($userData['createdAt']));
            }
            if (isset($userData['id'])) {
                $this->setId($user, $userData['id']);
            }
            $this->get('kreta_user.repository.user')->persist($user);
        }
    }
}
