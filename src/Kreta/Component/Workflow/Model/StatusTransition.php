<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Component\Workflow\Model;

use Finite\Transition\Transition;
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
     * {@inheritdoc}
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
    public function __construct($name, array $initialStates = [], StatusInterface $state)
    {
        parent::__construct($name, $initialStates, $state);
        $this->workflow = $state->getWorkflow();
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
    public function getWorkflow()
    {
        return $this->workflow;
    }
}
