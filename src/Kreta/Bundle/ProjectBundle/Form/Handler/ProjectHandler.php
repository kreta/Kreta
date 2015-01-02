<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Bundle\ProjectBundle\Form\Handler;

use Doctrine\Common\Persistence\ObjectManager;
use Kreta\Bundle\CoreBundle\Form\Handler\Abstracts\AbstractHandler;
use Kreta\Bundle\ProjectBundle\Form\Type\ProjectType;
use Kreta\Component\Media\Factory\MediaFactory;
use Kreta\Component\Media\Uploader\MediaUploader;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\FileBag;

/**
 * Class ProjectHandler.
 *
 * @package Kreta\Bundle\ProjectBundle\Form\Handler
 */
class ProjectHandler extends AbstractHandler
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
     * {@inheritdoc}
     */
    protected $successMessage = 'Project saved successfully';

    /**
     * {@inheritdoc}
     */
    protected $errorMessage = 'Error saving project';

    /**
     * Constructor.
     *
     * @param \Symfony\Component\Form\FormFactory                         $formFactory     Creates a new Form instance
     * @param \Doctrine\Common\Persistence\ObjectManager                  $manager         Persists and flush the object
     * @param \Symfony\Component\EventDispatcher\EventDispatcherInterface $eventDispatcher Dispatches FormHandlerEvents
     * @param \Kreta\Component\Media\Factory\MediaFactory                 $mediaFactory    Creates a new Project image
     * @param \Kreta\Component\Media\Uploader\MediaUploader               $uploader        Uploads Project images
     */
    public function __construct(
        FormFactory $formFactory,
        ObjectManager $manager,
        EventDispatcherInterface $eventDispatcher,
        MediaFactory $mediaFactory,
        MediaUploader $uploader
    )
    {
        parent::__construct($formFactory, $manager, $eventDispatcher);
        $this->mediaFactory = $mediaFactory;
        $this->uploader = $uploader;
    }

    /**
     * {@inheritdoc}
     */
    protected function createForm($object, array $formOptions = [])
    {
        return $this->formFactory->create(new ProjectType(), $object, $formOptions);
    }

    /**
     * {@inheritdoc}
     */
    protected function handleFiles(FileBag $files, $object)
    {
        $image = $files->get('kreta_project_project_type')['image'];
        if ($image instanceof UploadedFile) {
            $media = $this->mediaFactory->create($image);
            $this->uploader->upload($media);
            $object->setImage($media);
        }
    }
}
