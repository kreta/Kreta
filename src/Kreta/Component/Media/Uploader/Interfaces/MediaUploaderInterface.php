<?php

/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Component\Media\Uploader\Interfaces;

use Kreta\Component\Media\Model\Interfaces\MediaInterface;

/**
 * Interface MediaUploaderInterface.
 *
 * @package Kreta\Component\Media\Uploader\Interfaces
 */
interface MediaUploaderInterface
{
    /**
     * Uploads the media.
     *
     * @param \Kreta\Component\Media\Model\Interfaces\MediaInterface $media The media
     * @param string                                                 $name  File name, useful to assign the name in test
     * @param boolean                                                $test  Checks if it's in test mode or not. If it's
     *                                                                      true the file is not uploaded
     *
     * @return void
     */
    public function upload(MediaInterface $media, $name = null, $test = null);

    /**
     * Removes the media.
     *
     * @param string $name The name
     *
     * @return boolean
     */
    public function remove($name);
}
