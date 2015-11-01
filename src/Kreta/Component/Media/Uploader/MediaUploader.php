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

namespace Kreta\Component\Media\Uploader;

use Gaufrette\Filesystem;
use Kreta\Component\Media\Model\Interfaces\MediaInterface;
use Kreta\Component\Media\Uploader\Interfaces\MediaUploaderInterface;

/**
 * Class MediaUploader.
 *
 * @package Kreta\Component\Media\Uploader
 */
class MediaUploader implements MediaUploaderInterface
{
    /**
     * The file system.
     *
     * @var \Gaufrette\Filesystem
     */
    protected $filesystem;

    /**
     * Constructor.
     *
     * @param Filesystem $filesystem The file system
     */
    public function __construct(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;
    }

    /**
     * {@inheritdoc}
     */
    public function upload(MediaInterface $media, $name = null, $test = false)
    {
        if (!$media->hasMedia()) {
            return;
        }

        if (null !== $media->getName()) {
            $this->remove($media->getName());
        }

        do {
            $hash = md5(uniqid(mt_rand(), true));
            if ($test === false) {
                $name = $hash . '.' . $media->getMedia()->guessExtension();
            }
        } while ($this->filesystem->has($name));

        $media->setName($name);

        if ($test === false) {
            $this->filesystem->write(
                $media->getName(),
                file_get_contents($media->getMedia()->getPathname())
            );
        }
    }

    /**
     * {@inheritdoc}
     */
    public function remove($name)
    {
        return $this->filesystem->delete($name);
    }
}
