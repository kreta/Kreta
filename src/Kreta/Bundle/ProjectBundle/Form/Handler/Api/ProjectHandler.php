<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Bundle\ProjectBundle\Form\Handler\Api;

use Doctrine\Common\Persistence\ObjectManager;
use Kreta\Bundle\CoreBundle\Form\Handler\Handler;
use Kreta\Component\Media\Factory\MediaFactory;
use Kreta\Component\Media\Uploader\MediaUploader;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\FileBag;

/**
 * Class ProjectHandler.
 *
 * @package Kreta\Bundle\ProjectBundle\Form\Handler\Api
 */
class ProjectHandler extends Handler
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
     * @param \Symfony\Component\Form\FormFactory           $formFactory  Creates a new Form instance
     * @param \Doctrine\Common\Persistence\ObjectManager    $manager      Persists and flush the object
     * @param string                                        $formName     The name of the form
     * @param \Kreta\Component\Media\Factory\MediaFactory   $mediaFactory Creates a new Project image
     * @param \Kreta\Component\Media\Uploader\MediaUploader $uploader     Uploads Project images
     */
    public function __construct(
        FormFactory $formFactory,
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
    protected function handleFiles(FileBag $files, $project)
    {
        $image = $files->get('image');
        if ($image instanceof UploadedFile) {
            $media = $this->mediaFactory->create($image);
            $this->uploader->upload($media);
            $project->setImage($media);
        }
    }
}
