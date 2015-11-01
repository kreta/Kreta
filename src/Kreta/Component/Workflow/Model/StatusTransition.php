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

namespace Kreta\Component\Workflow\Model;

use Doctrine\ORM\NoResultException;
use Finite\Transition\Transition;
use Kreta\Component\Core\Exception\CollectionMinLengthException;
use Kreta\Component\Core\Exception\ResourceAlreadyPersistException;
use Kreta\Component\Workflow\Model\Interfaces\StatusInterface;
use Kreta\Component\Workflow\Model\Interfaces\StatusTransitionInterface;

/**
 * Class StatusTransition.
 *
 * @package Kreta\Component\Workflow\Model
 */
class StatusTransition extends Transition implements StatusTransitionInterface
{
    /**
     * The id.
     *
     * @var string
     */
    protected $id;

    /**
     * {@inheritdoc}
     */
    protected $initialStates;

    /**
     * {@inheritdoc}
     */
    protected $name;

    /**
     * The status.
     *
     * @var \Kreta\Component\Workflow\Model\Interfaces\StatusInterface
     */
    protected $state;

    /**
     * The workflow.
     *
     * @var \Kreta\Component\Workflow\Model\Interfaces\WorkflowInterface
     */
    protected $workflow;

    /**
     * Constructor.
     *
     * @param string                                                       $name          The name of transition
     * @param \Kreta\Component\Workflow\Model\Interfaces\StatusInterface[] $initialStates Array that contains
     *                                                                                    the initial states
     * @param \Kreta\Component\Workflow\Model\Interfaces\StatusInterface   $state         The status
     */
    public function __construct($name, array $initialStates = [], StatusInterface $state = null)
    {
        parent::__construct($name, $initialStates, $state);

        if ($state instanceof StatusInterface) {
            $this->workflow = $state->getWorkflow();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getInitialState($initialStatusId)
    {
        foreach ($this->initialStates as $initialStatus) {
            if ($initialStatus->getId() === $initialStatusId) {
                return $initialStatus;
            }
        }
        throw new NoResultException();
    }

    /**
     * {@inheritdoc}
     */
    public function addInitialState($status)
    {
        if (!($status instanceof StatusInterface)) {
            throw new \InvalidArgumentException('Invalid argument passed, it is not an instance of StatusInterface');
        }

        if ($status->getWorkflow()->getId() !== $this->getWorkflow()->getId()) {
            throw new \InvalidArgumentException('The initial status given is not from transition\'s workflow');
        }

        $statusId = $status->getId();
        foreach ($this->initialStates as $initialStatus) {
            if ($initialStatus->getId() === $statusId || $this->state === $statusId) {
                throw new ResourceAlreadyPersistException();
            }
        }
        $this->initialStates[] = $status;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function removeInitialState(StatusInterface $status)
    {
        if (count($this->initialStates) < 2) {
            throw new CollectionMinLengthException();
        }

        foreach ($this->initialStates as $index => $initialStatus) {
            if ($initialStatus->getId() === $status->getId()) {
                unset($this->initialStates[$index]);
                return $this;
            }
        }
        throw new NoResultException();
    }

    /**
     * {@inheritdoc}
     */
    public function getWorkflow()
    {
        return $this->workflow;
    }

    /**
     * {@inheritdoc}
     */
    public function isInUse()
    {
        foreach ($this->getWorkflow()->getProjects() as $project) {
            foreach ($project->getIssues() as $issue) {
                foreach ($issue->getStatus()->getTransitions() as $transition) {
                    if ($transition->getId() === $this->id) {
                        return true;
                    }
                }
            }
        }

        return false;
    }

    /**
     * Method which validates if the state is also an initial state.
     * It is a validation method with its assertions.
     *
     * @return boolean
     */
    public function isValidState()
    {
        if ($this->state instanceof StatusInterface) {
            foreach ($this->initialStates as $initialState) {
                if ($initialState->getId() === $this->state->getId()) {
                    return false;
                }
            }
        }

        return true;
    }
}
