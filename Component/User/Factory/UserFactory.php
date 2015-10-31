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

use Kreta\Component\Media\Factory\MediaFactory;
use Kreta\Component\Media\Uploader\Interfaces\MediaUploaderInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

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
     * The media factory.
     *
     * @var \Kreta\Component\Media\Factory\MediaFactory
     */
    protected $mediaFactory;

    /**
     * The path.
     *
     * @var string|null
     */
    protected $path;

    /**
     * The uploader.
     *
     * @var \Kreta\Component\Media\Uploader\Interfaces\MediaUploaderInterface
     */
    protected $uploader;

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
