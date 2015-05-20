<?php

/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Bundle\UserBundle\Behat\Context;

use Behat\Gherkin\Node\TableNode;
use Kreta\Bundle\CoreBundle\Behat\Context\DefaultContext;

/**
 * Class UserContext.
 *
 * @package Kreta\Bundle\UserBundle\Behat\Context
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
            $enabled = true;
            if (isset($userData['enabled'])) {
                $enabled = filter_var($userData['enabled'], FILTER_VALIDATE_BOOLEAN);
            }
            $user = $this->get('kreta_user.factory.user')->create($userData['email'], $enabled);
            $user
                ->setFirstname($userData['firstName'])
                ->setLastname($userData['lastName'])
                ->setPlainPassword($userData['password']);

            if (isset($userData['roles'])) {
                $roles = explode(',', $userData['roles']);
                $this->setField($user, 'roles', $roles);
            }

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
