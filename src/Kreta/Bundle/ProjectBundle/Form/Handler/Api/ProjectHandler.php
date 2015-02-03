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
use Kreta\Bundle\ProjectBundle\Form\Type\Api\ProjectType;
use Kreta\Bundle\ProjectBundle\Form\Handler\ProjectHandler as BaseProjectFormHandler;
use Kreta\Component\Media\Factory\MediaFactory;
use Kreta\Component\Media\Uploader\MediaUploader;
use Kreta\Component\Project\Factory\ProjectFactory;
use Kreta\Component\Workflow\Repository\WorkflowRepository;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\FileBag;
use Symfony\Component\Security\Core\SecurityContextInterface;

/**
 * Class ProjectHandler.
 *
 * @package Kreta\Bundle\ProjectBundle\Form\Handler\Api
 */
class ProjectHandler extends BaseProjectFormHandler
{
    /**
     * The context.
     *
     * @var \Symfony\Component\Security\Core\SecurityContextInterface
     */
    protected $context;

    /**
     * The project factory.
     *
     * @var \Kreta\Component\Project\Factory\ProjectFactory
     */
    protected $factory;

    /**
     * The workflow repository.
     *
     * @var \Kreta\Component\Workflow\Repository\WorkflowRepository
     */
    protected $workflowRepository;

    /**
     * Constructor.
     *
     * @param \Symfony\Component\Form\FormFactory                         $formFactory        The form factory
     * @param \Doctrine\Common\Persistence\ObjectManager                  $manager            The manager
     * @param \Symfony\Component\EventDispatcher\EventDispatcherInterface $eventDispatcher    The event dispatcher
     * @param \Kreta\Component\Media\Factory\MediaFactory                 $mediaFactory       The media factory
     * @param \Kreta\Component\Media\Uploader\MediaUploader               $uploader           Uploads Project images
     * @param \Symfony\Component\Security\Core\SecurityContextInterface   $context            The security context
     * @param \Kreta\Component\Project\Factory\ProjectFactory             $projectFactory     The project factory
     * @param \Kreta\Component\Workflow\Repository\WorkflowRepository     $workflowRepository The workflow repository
     */
    public function __construct(
        FormFactory $formFactory,
        ObjectManager $manager,
        EventDispatcherInterface $eventDispatcher,
        MediaFactory $mediaFactory,
        MediaUploader $uploader,
        SecurityContextInterface $context,
        ProjectFactory $projectFactory,
        WorkflowRepository $workflowRepository
    )
    {
        parent::__construct($formFactory, $manager, $eventDispatcher, $mediaFactory, $uploader);
        $this->context = $context;
        $this->factory = $projectFactory;
        $this->workflowRepository = $workflowRepository;
    }

    /**
     * {@inheritdoc}
     */
    protected function createForm($object = null, array $formOptions = [])
    {
        return $this->formFactory->create(
            new ProjectType($this->context, $this->factory, $this->workflowRepository), $object, $formOptions
        );
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
