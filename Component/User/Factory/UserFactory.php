<?php

/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
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
     * @param string  $email   The email
     * @param boolean $enabled Boolean that checks if the user is enabled or not, by default is false
     *
     * @return \Kreta\Component\User\Model\Interfaces\UserInterface
     */
    public function create($email, $enabled = false)
    {
        $user = new $this->className();

        if (false === $enabled) {
            $user->setConfirmationToken(sprintf('%s%s', uniqid('kreta'), unixtojd()));
        }

        return $user
            ->setEmail($email)
            ->setEnabled($enabled);
    }
}
