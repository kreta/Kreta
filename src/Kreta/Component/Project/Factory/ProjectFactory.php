<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Component\Project\Factory;

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
     * @var \Kreta\Component\Project\Factory\ParticipantFactory
     */
    protected $participantFactory;

    /**
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
     * @param \Kreta\Component\User\Model\Interfaces\UserInterface         $user     Creator that will be set as admin
     * @param \Kreta\Component\Workflow\Model\Interfaces\WorkflowInterface $workflow The workflow
     *
     * @return \Kreta\Component\Project\Model\Interfaces\ProjectInterface
     */
    public function create(UserInterface $user, WorkflowInterface $workflow = null)
    {
        $project = new $this->className();

        $participant = $this->participantFactory->create($project, $user, 'ROLE_ADMIN');
        if (!($workflow instanceof WorkflowInterface)) {
            $workflow = $this->workflowFactory->create(self::DEFAULT_WORKFLOW_NAME, $user, true);
        }

        return $project
            ->addParticipant($participant)
            ->setWorkflow($workflow);
    }
}
