<?php

/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Component\User\Model;

use FOS\UserBundle\Model\User as BaseUser;
use Kreta\Component\Media\Model\Interfaces\MediaInterface;
use Kreta\Component\User\Model\Interfaces\UserInterface;

/**
 * Class User.
 *
 * @package Kreta\Component\User\Model
 */
class User extends BaseUser implements UserInterface
{
    /**
     * Created at.
     *
     * @var \DateTime
     */
    protected $createdAt;

    /**
     * The first name.
     *
     * @var string
     */
    protected $firstName;

    /**
     * The last name.
     *
     * @var string
     */
    protected $lastName;

    /**
     * The photo.
     *
     * @var \Kreta\Component\Media\Model\Interfaces\MediaInterface
     */
    protected $photo;

    /**
     * Constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->createdAt = new \DateTime();
    }

    /**
     * {@inheritdoc}
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * {@inheritdoc}
     */
    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * {@inheritdoc}
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getFullName()
    {
        if ($this->firstName !== null && $this->lastName !== null) {
            return $this->firstName . ' ' . $this->lastName;
        }

        if ($this->firstName !== null) {
            return $this->firstName;
        }

        if ($this->lastName !== null) {
            return $this->lastName;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * {@inheritdoc}
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * {@inheritdoc}
     */
    public function setPhoto(MediaInterface $photo)
    {
        $this->photo = $photo;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setEmail($email)
    {
        parent::setEmail($email);
        parent::setUsername($email);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setEmailCanonical($emailCanonical)
    {
        parent::setEmailCanonical($emailCanonical);
        parent::setUsernameCanonical($emailCanonical);

        return $this;
    }
}
