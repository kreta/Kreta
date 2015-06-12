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
    const DEFAULT_PHOTO_PATH = '/../../../Bundle/UserBundle/Resources/public/img/';
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
     */
    public function __construct($className, MediaFactory $mediaFactory, MediaUploaderInterface $uploader)
    {
        $this->className = $className;
        $this->mediaFactory = $mediaFactory;
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

        $photo = $this->mediaFactory->create(
            new UploadedFile(
                __DIR__ . self::DEFAULT_PHOTO_PATH . self::DEFAULT_PHOTO_FILENAME, self::DEFAULT_PHOTO_FILENAME
            )
        );
        $this->uploader->upload($photo);

        return $user
            ->setUsername($username)
            ->setFirstName($firstName)
            ->setLastName($lastName)
            ->setEmail($email)
            ->setEnabled($enabled)
            ->setPhoto($photo);
    }
}
