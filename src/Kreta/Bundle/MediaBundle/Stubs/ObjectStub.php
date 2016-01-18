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

namespace Kreta\Bundle\MediaBundle\Stubs;

use Kreta\Component\Media\Model\Interfaces\MediaInterface;

/**
 * Class ObjectStub.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
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
        return $this->media;
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
