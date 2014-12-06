<?php
/**
 * Created by PhpStorm.
 * User: gorkalaucirica
 * Date: 6/12/14
 * Time: 10:45
 */

namespace Kreta\Bundle\WebBundle\FormHandler;


use Doctrine\Common\Persistence\ObjectManager;
use Kreta\Bundle\CoreBundle\Form\Type\ProjectType;
use Kreta\Component\Core\Factory\MediaFactory;
use Kreta\Component\Core\Uploader\MediaUploader;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\FileBag;

/**
 * Class ProjectFormHandler
 *
 * @package Kreta\Bundle\WebBundle\FormHandler
 */
class ProjectFormHandler extends AbstractFormHandler
{
    /**
     * @var MediaFactory
     */
    protected $mediaFactory;

    protected $uploader;

    protected $successMessage = 'Project saved successfully';

    protected $errorMessage = 'Error saving project';

    /**
     * @param FormFactory     $formFactory     Used to create a new Form instance
     * @param ObjectManager   $manager         Used to persist and flush the object
     * @param EventDispatcher $eventDispatcher Used to dispatch FormHandlerEvents
     * @param MediaFactory    $mediaFactory    Used to create a new Project image
     * @param MediaUploader   $uploader        Used to upload Project images
     */
    public function __construct(FormFactory $formFactory, ObjectManager $manager, EventDispatcher $eventDispatcher,
                                MediaFactory $mediaFactory, MediaUploader $uploader)
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
        return $this->formFactory->create(new ProjectType(), $object);
    }

    /**
     * {@inheritdoc}
     */
    protected function handleFiles(FileBag $files, $object)
    {
        $image = $files->get('kreta_core_project_type')['image'];
        if ($image instanceof UploadedFile) {
            $media = $this->mediaFactory->create($image);
            $this->uploader->upload($media);
            $object->setImage($media);
        }
    }

}
