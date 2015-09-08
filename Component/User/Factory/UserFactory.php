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
    const DEFAULT_PHOTO_FILENAME = 'default.png';

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
     * @param string                                                            $className    The class name
     * @param \Kreta\Component\Media\Factory\MediaFactory                       $mediaFactory The media factory
     * @param \Kreta\Component\Media\Uploader\Interfaces\MediaUploaderInterface $uploader     The uploader
     * @param string|null                                                       $path         The path, by default null
     */
    public function __construct($className, MediaFactory $mediaFactory, MediaUploaderInterface $uploader, $path = null)
    {
        $this->className = $className;
        $this->mediaFactory = $mediaFactory;
        $this->path = $path;
        $this->uploader = $uploader;
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

        if (null !== $this->path) {
            $photo = $this->mediaFactory->create(
                new UploadedFile(
                    __DIR__ . '/' . $this->path . self::DEFAULT_PHOTO_FILENAME, self::DEFAULT_PHOTO_FILENAME
                )
            );
            $this->uploader->upload($photo);
            $user->setPhoto($photo);
        }

        return $user
            ->setUsername($username)
            ->setFirstName($firstName)
            ->setLastName($lastName)
            ->setEmail($email)
            ->setEnabled($enabled);
    }
}
