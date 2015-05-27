<?php

/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Bundle\MediaBundle\Stubs;

use Kreta\Component\Media\Model\Interfaces\MediaInterface;
use Kreta\Component\Media\Model\Media;

/**
 * Class ObjectStub.
 *
 * @package Kreta\Bundle\MediaBundle\Stubs
 */
class ObjectStub
{
    /**
     * The media.
     *
     * @var \Kreta\Component\Media\Model\Interfaces\MediaInterface
     */
    private $media;

    /**
     * Gets image.
     *
     * @return \Kreta\Component\Media\Model\Media
     */
    public function getImage()
    {
        return $media;
    }

    /**
     * Sets media.
     *
     * @param \Kreta\Component\Media\Model\Interfaces\MediaInterface $media
     *
     * @return self $this Object
     */
    public function setImage(MediaInterface $media)
    {
        $this->media = $media;

        return $this;
    }
}
