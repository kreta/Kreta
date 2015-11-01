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

namespace Kreta\Component\Project\Factory;

use Kreta\Component\Media\Factory\MediaFactory;
use Kreta\Component\Media\Model\Interfaces\MediaInterface;
use Kreta\Component\Media\Uploader\Interfaces\MediaUploaderInterface;
use Kreta\Component\Project\Model\Interfaces\ProjectInterface;
use Kreta\Component\Project\Model\IssuePriority;
use Kreta\Component\User\Model\Interfaces\UserInterface;
use Kreta\Component\Workflow\Factory\WorkflowFactory;
use Kreta\Component\Workflow\Model\Interfaces\WorkflowInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class ProjectFactory.
 *
 * @package Kreta\Component\Project\Factory
 */
class ProjectFactory
{
    const DEFAULT_WORKFLOW_NAME = 'Default KRETA workflow';
    const DEFAULT_IMAGE_PATH = '/../../../Bundle/ProjectBundle/Resources/public/img/';
    const DEFAULT_IMAGE_FILENAME = 'default.png';

    /**
     * The class name.
     *
     * @var string
     */
    protected $className;

    /**
     * The participant factory.
     *
     * @var \Kreta\Component\Project\Factory\ParticipantFactory
     */
    protected $participantFactory;

    /**
     * The workflow factory.
     *
     * @var \Kreta\Component\Workflow\Factory\WorkflowFactory
     */
    protected $workflowFactory;

    /**
     * The media factory.
     *
     * @var \Kreta\Component\Media\Factory\MediaFactory
     */
    protected $mediaFactory;

    /**
     * The uploader.
     *
     * @var \Kreta\Component\Media\Uploader\Interfaces\MediaUploaderInterface
     */
    protected $uploader;

    /**
     * Constructor.
     *
     * @param string                 $className          The class name
     * @param ParticipantFactory     $participantFactory Factory needed to add creator as participant
     * @param WorkflowFactory        $workflowFactory    Factory needed to add workflow by default
     * @param MediaFactory           $mediaFactory       The media factory
     * @param MediaUploaderInterface $uploader           The uploader
     */
    public function __construct(
        $className,
        ParticipantFactory $participantFactory,
        WorkflowFactory $workflowFactory,
        MediaFactory $mediaFactory,
        MediaUploaderInterface $uploader
    )
    {
        $this->className = $className;
        $this->participantFactory = $participantFactory;
        $this->workflowFactory = $workflowFactory;
        $this->mediaFactory = $mediaFactory;
        $this->uploader = $uploader;
    }

    /**
     * Creates an instance of a project.
     *
     * @param \Kreta\Component\User\Model\Interfaces\UserInterface              $user     The project creator
     * @param \Kreta\Component\Workflow\Model\Interfaces\WorkflowInterface|null $workflow The workflow
     * @param boolean                                                           $load     Load boolean, by default true
     * @param \Kreta\Component\Media\Model\Interfaces\MediaInterface            $image    The image, can be null
     *
     * @return \Kreta\Component\Project\Model\Interfaces\ProjectInterface
     */
    public function create(
        UserInterface $user,
        WorkflowInterface $workflow = null,
        $load = true,
        MediaInterface $image = null
    )
    {
        $project = new $this->className();

        $participant = $this->participantFactory->create($project, $user, 'ROLE_ADMIN');
        if (!($workflow instanceof WorkflowInterface)) {
            $workflow = $this->workflowFactory->create(self::DEFAULT_WORKFLOW_NAME, $user, true);
        }

        if ($load) {
            $project = $this->loadPrioritiesAndTypes($project);
        }

        if (!$image instanceof MediaInterface) {
            $image = $this->mediaFactory->create(
                new UploadedFile(
                    __DIR__ . self::DEFAULT_IMAGE_PATH . self::DEFAULT_IMAGE_FILENAME, self::DEFAULT_IMAGE_FILENAME
                )
            );
        }
        $this->uploader->upload($image);

        return $project
            ->setImage($image)
            ->addParticipant($participant)
            ->setWorkflow($workflow);
    }

    /**
     * Loads the default issue priorities and types.
     *
     * @param \Kreta\Component\Project\Model\Interfaces\ProjectInterface $project The project
     *
     * @return \Kreta\Component\Project\Model\Interfaces\ProjectInterface
     */
    protected function loadPrioritiesAndTypes(ProjectInterface $project)
    {
        $priorities = $this->createDefaultPriorities();
        foreach ($priorities as $priority) {
            $priority->setProject($project);
            $project->addIssuePriority($priority);
        }

        return $project;
    }

    /**
     * Creates some default priorities to add into project when this is created.
     *
     * @return \Kreta\Component\Project\Model\Interfaces\IssuePriorityInterface[]
     */
    protected function createDefaultPriorities()
    {
        $defaultPriorityNames = ['Low', 'Medium', 'High', 'Blocker'];
        $priorities = [];
        foreach ($defaultPriorityNames as $name) {
            $priority = new IssuePriority();
            $priority->setName($name);
            $priorities[$name] = $priority;
        }

        return $priorities;
    }
}
