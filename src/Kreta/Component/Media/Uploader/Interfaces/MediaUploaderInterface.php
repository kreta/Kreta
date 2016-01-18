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

namespace Kreta\Component\Media\Uploader\Interfaces;

use Kreta\Component\Media\Model\Interfaces\MediaInterface;

/**
 * Interface MediaUploaderInterface.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
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
