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

namespace Kreta\Component\User\Factory;

/**
 * Class UserFactory.
 *
 * @package Kreta\Component\User\Factory
 */
class UserFactory
{
    /**
     * The class name.
     *
     * @var string
     */
    protected $className;

    /**
     * Constructor.
     *
     * @param string $className The class name
     */
    public function __construct($className)
    {
        $this->className = $className;
    }

    /**
     * Creates an instance of user.
     *
     * @param string  $email     The email
     * @param string  $username  The username
     * @param string  $firstName The firstName
     * @param string  $lastName  The lastName
     * @param boolean $enabled   Boolean that checks if the user is enabled or not, by default is false
     *
     * @return \Kreta\Component\User\Model\Interfaces\UserInterface
     */
    public function create($email, $username, $firstName, $lastName, $enabled = false)
    {
        $user = new $this->className();

        if (false === $enabled) {
            $user->setConfirmationToken(sprintf('%s%s', uniqid('kreta'), unixtojd()));
        }

        return $user
            ->setUsername($username)
            ->setFirstName($firstName)
            ->setLastName($lastName)
            ->setEmail($email)
            ->setEnabled($enabled);
    }
}
