<?php

/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
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
 * @package Kreta\Component\User\Form\Handler
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
