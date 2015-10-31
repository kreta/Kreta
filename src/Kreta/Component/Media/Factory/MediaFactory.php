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
