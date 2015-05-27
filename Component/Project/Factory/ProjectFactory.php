<?php

/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Component\Project\Factory;

use Kreta\Component\Project\Model\Interfaces\ProjectInterface;
use Kreta\Component\Project\Model\IssuePriority;
use Kreta\Component\Project\Model\IssueType;
use Kreta\Component\User\Model\Interfaces\UserInterface;
use Kreta\Component\Workflow\Factory\WorkflowFactory;
use Kreta\Component\Workflow\Model\Interfaces\WorkflowInterface;

/**
 * Class ProjectFactory.
 *
 * @package Kreta\Component\Project\Factory
 */
class ProjectFactory
{
    const DEFAULT_WORKFLOW_NAME = 'Default KRETA workflow';

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
     * Constructor.
     *
     * @param string                                              $className          The class name
     * @param \Kreta\Component\Project\Factory\ParticipantFactory $participantFactory Factory needed to add creator as
     *                                                                                participant
     * @param \Kreta\Component\Workflow\Factory\WorkflowFactory   $workflowFactory    Factory needed to add workflow by
     *                                                                                default
     */
    public function __construct($className, ParticipantFactory $participantFactory, WorkflowFactory $workflowFactory)
    {
        $this->className = $className;
        $this->participantFactory = $participantFactory;
        $this->workflowFactory = $workflowFactory;
    }

    /**
     * Creates an instance of a project.
     *
     * @param \Kreta\Component\User\Model\Interfaces\UserInterface              $user     The project creator
     * @param \Kreta\Component\Workflow\Model\Interfaces\WorkflowInterface|null $workflow The workflow
     * @param boolean                                                           $load     Load boolean, by default true
     *
     * @return \Kreta\Component\Project\Model\Interfaces\ProjectInterface
     */
    public function create(UserInterface $user, WorkflowInterface $workflow = null, $load = true)
    {
        $project = new $this->className();

        $participant = $this->participantFactory->create($project, $user, 'ROLE_ADMIN');
        if (!($workflow instanceof WorkflowInterface)) {
            $workflow = $this->workflowFactory->create(self::DEFAULT_WORKFLOW_NAME, $user, true);
        }

        if ($load) {
            $project = $this->loadPrioritiesAndTypes($project);
        }

        return $project
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
        $types = $this->createDefaultTypes();
        foreach ($types as $type) {
            $type->setProject($project);
            $project->addIssueType($type);
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

    /**
     * Creates some default priorities to add into project when this is created.
     *
     * @return \Kreta\Component\Project\Model\Interfaces\IssueTypeInterface[]
     */
    protected function createDefaultTypes()
    {
        $defaultTypeNames = ['Improvement', 'Story', 'Bug', 'Feature'];
        $types = [];
        foreach ($defaultTypeNames as $name) {
            $type = new IssueType();
            $type->setName($name);
            $types[$name] = $type;
        }

        return $types;
    }
}
