<?php

/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Component\Media\Factory;

use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class MediaFactory.
 *
 * @package Kreta\Component\Media\Factory
 */
class MediaFactory
{
    /**
     * The class name.
     *
     * @var string
     */
    protected $className;

    /**
     * Constructor.
     *
     * @param string $className The class name
     */
    public function __construct($className)
    {
        $this->className = $className;
    }

    /**
     * Creates an instance of Media.
     *
     * @param \Symfony\Component\HttpFoundation\File\UploadedFile $file The uploaded file
     *
     * @return \Kreta\Component\Media\Model\Interfaces\MediaInterface
     */
    public function create(UploadedFile $file)
    {
        $media = new $this->className();

        return $media
            ->setMedia($file);
    }
}
