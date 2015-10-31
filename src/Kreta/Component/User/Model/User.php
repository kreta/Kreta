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
        $this->plainPassword = uniqid();
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
}
