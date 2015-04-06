<?php

/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Component\Media\Model\Interfaces;

use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Interface MediaInterface.
 *
 * @package Kreta\Component\Media\Model\Interfaces
 */
interface MediaInterface
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
     * Gets media.
     *
     * @return \Symfony\Component\HttpFoundation\File\UploadedFile
     */
    public function getMedia();

    /**
     * Sets media.
     *
     * @param \Symfony\Component\HttpFoundation\File\UploadedFile $media The media
     *
     * @return $this self Object
     */
    public function setMedia(UploadedFile $media = null);

    /**
     * Has media returns true if the object has a media, otherwise returns false.
     *
     * @return boolean
     */
    public function hasMedia();

    /**
     * Gets name.
     *
     * @return string
     */
    public function getName();

    /**
     * Sets name.
     *
     * @param string $name The name
     *
     * @return $this self Object
     */
    public function setName($name);

    /**
     * Gets updated at.
     *
     * @return \DateTime
     */
    public function getUpdatedAt();

    /**
     * Sets updated at.
     *
     * @param \DateTime $updatedAt The updated at.
     *
     * @return $this self Object
     */
    public function setUpdatedAt(\DateTime $updatedAt);
}
