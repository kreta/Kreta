<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Bundle\WebBundle\FormHandler;

use Doctrine\Common\Persistence\ObjectManager;
use Kreta\Bundle\CoreBundle\Form\Type\UserType;
use Kreta\Component\Core\Factory\MediaFactory;
use Kreta\Component\Core\Uploader\MediaUploader;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\FileBag;

/**
 * Class UserFormHandler
 *
 * @package Kreta\Bundle\WebBundle\FormHandler
 */
class UserFormHandler extends AbstractFormHandler
{
    /**
     * @var MediaFactory
     */
    protected $mediaFactory;

    protected $uploader;

    /**
     * @param FormFactory              $formFactory     Used to create a new Form instance
     * @param ObjectManager            $manager         Used to persist and flush the object
     * @param EventDispatcherInterface $eventDispatcher Used to dispatch FormHandlerEvents
     * @param MediaFactory             $mediaFactory    Used to create a new User picture
     * @param MediaUploader            $uploader        Used to upload User pictures
     */
    public function __construct(FormFactory $formFactory, ObjectManager $manager,
                                EventDispatcherInterface $eventDispatcher, MediaFactory $mediaFactory,
                                MediaUploader $uploader)
    {
        parent::__construct($formFactory, $manager, $eventDispatcher);
        $this->mediaFactory = $mediaFactory;
        $this->uploader = $uploader;
    }

    /**
     * {@inheritdoc}
     */
    protected function createForm($object, $formOptions = null)
    {
        return $this->formFactory->create(new UserType(), $object);
    }

    /**
     * {@inheritdoc}
     */
    protected function handleFiles(FileBag $files, $object)
    {
        $image = $files->get('kreta_core_user_type')['photo'];
        if ($image instanceof UploadedFile) {
            $media = $this->mediaFactory->create($image);
            $this->uploader->upload($media);
            $object->setPhoto($media);
        }
    }

}

