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

namespace Kreta\Component\User\Model\Interfaces;

use FOS\UserBundle\Model\UserInterface as BaseUserInterface;
use Kreta\Component\Media\Model\Interfaces\MediaInterface;

/**
 * Interface UserInterface.
 *
 * @package Kreta\Component\User\Model\Interfaces
 */
interface UserInterface extends BaseUserInterface
{
    /**
     * Gets id.
     *
     * @return string
     */
    public function getId();

    /**
     * Gets created at.
     *
     * @return \DateTime
     */
    public function getCreatedAt();

    /**
     * Sets created at.
     *
     * @param \DateTime $createdAt The created at.
     *
     * @return $this self Object
     */
    public function setCreatedAt(\DateTime $createdAt);

    /**
     * Gets first name.
     *
     * @return string
     */
    public function getFirstName();

    /**
     * Sets first name.
     *
     * @param string $firstName The first name
     *
     * @return $this self Object
     */
    public function setFirstName($firstName);

    /**
     * Gets last name.
     *
     * @return string
     */
    public function getLastName();

    /**
     * Sets last name.
     *
     * @param string $lastName The last name
     *
     * @return $this self Object
     */
    public function setLastName($lastName);

    /**
     * Gets photo.
     *
     * @return \Kreta\Component\Media\Model\Interfaces\MediaInterface
     */
    public function getPhoto();

    /**
     * Sets photo.
     *
     * @param \Kreta\Component\Media\Model\Interfaces\MediaInterface $photo The photo
     *
     * @return $this self Object
     */
    public function setPhoto(MediaInterface $photo);
}
