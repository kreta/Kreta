<?php

/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Kreta\Bundle\UserBundle\Behat\Context;

use Behat\Gherkin\Node\TableNode;
use Kreta\Bundle\CoreBundle\Behat\Context\DefaultContext;

/**
 * Class UserContext.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
 */
class UserContext extends DefaultContext
{
    /**
     * Populates the database with users.
     *
     * @param \Behat\Gherkin\Node\TableNode $users The users
     *
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
            $user = $this->get('kreta_user.factory.user')->create(
                $userData['email'],
                $userData['username'],
                $userData['firstName'],
                $userData['lastName'],
                $enabled
            );
            $user->setPlainPassword($userData['password']);

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
            if (isset($userData['confirmationToken'])) {
                $user->setConfirmationToken($userData['confirmationToken']);
            }

            // Removes default photo that generates problems with auto-generate id
            $this->setField($user, 'photo', null);

            $this->get('kreta_user.repository.user')->persist($user);
        }
    }
}
