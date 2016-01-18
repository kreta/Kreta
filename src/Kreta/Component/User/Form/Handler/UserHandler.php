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

namespace Kreta\Component\User\Form\Handler;

use Doctrine\Common\Persistence\ObjectManager;
use Kreta\Component\Core\Form\Handler\Handler;
use Kreta\Component\Media\Factory\MediaFactory;
use Kreta\Component\Media\Uploader\MediaUploader;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\FileBag;

/**
 * Class UserHandler.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
 */
class UserHandler extends Handler
{
    /**
     * The media factory.
     *
     * @var \Kreta\Component\Media\Factory\MediaFactory
     */
    protected $mediaFactory;

    /**
     * The media uploader.
     *
     * @var \Kreta\Component\Media\Uploader\MediaUploader
     */
    protected $uploader;

    /**
     * Constructor.
     *
     * @param \Symfony\Component\Form\FormFactoryInterface  $formFactory  Creates a new Form instance
     * @param \Doctrine\Common\Persistence\ObjectManager    $manager      Persists and flush the object
     * @param string                                        $formName     The name of the form
     * @param \Kreta\Component\Media\Factory\MediaFactory   $mediaFactory Creates a new Project image
     * @param \Kreta\Component\Media\Uploader\MediaUploader $uploader     Uploads Project images
     */
    public function __construct(
        FormFactoryInterface $formFactory,
        ObjectManager $manager,
        $formName,
        MediaFactory $mediaFactory,
        MediaUploader $uploader
    )
    {
        parent::__construct($formFactory, $manager, $formName);
        $this->mediaFactory = $mediaFactory;
        $this->uploader = $uploader;
    }

    /**
     * {@inheritdoc}
     */
    protected function handleFiles(FileBag $files, $object)
    {
        $image = $files->get('photo');
        if ($image instanceof UploadedFile) {
            $media = $this->mediaFactory->create($image);
            $this->uploader->upload($media);
            $object->setPhoto($media);
        }
    }
}
