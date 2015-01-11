<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Bundle\UserBundle\Form\Handler;

use Doctrine\Common\Persistence\ObjectManager;
use Kreta\Bundle\CoreBundle\Form\Handler\Abstracts\AbstractHandler;
use Kreta\Bundle\UserBundle\Form\Type\UserType;
use Kreta\Component\Media\Factory\MediaFactory;
use Kreta\Component\Media\Uploader\MediaUploader;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\FileBag;

/**
 * Class UserHandler.
 *
 * @package Kreta\Bundle\UserBundle\Form\Handler
 */
class UserHandler extends AbstractHandler
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
     * @param \Symfony\Component\Form\FormFactory                         $formFactory     Creates a new Form instance
     * @param \Doctrine\Common\Persistence\ObjectManager                  $manager         Persists and flush the object
     * @param \Symfony\Component\EventDispatcher\EventDispatcherInterface $eventDispatcher Dispatches FormHandlerEvents
     * @param \Kreta\Component\Media\Factory\MediaFactory                  $mediaFactory    Creates a new Project image
     * @param \Kreta\Component\Media\Uploader\MediaUploader                $uploader        Uploads Project images
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
    protected function createForm($object = null, array $formOptions = [])
    {
        return $this->formFactory->create(new UserType(), $object, $formOptions);
    }

    /**
     * {@inheritdoc}
     */
    protected function handleFiles(FileBag $files, $object)
    {
        $image = $files->get('kreta_user_user_type')['photo'];
        if ($image instanceof UploadedFile) {
            $media = $this->mediaFactory->create($image);
            $this->uploader->upload($media);
            $object->setPhoto($media);
        }
    }

}

