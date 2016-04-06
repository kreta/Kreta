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

namespace Kreta\Component\Media\Model\Interfaces;

use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Interface MediaInterface.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
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
     * @return bool
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
