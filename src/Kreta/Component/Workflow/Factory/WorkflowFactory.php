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

namespace Kreta\Component\Workflow\Factory;

use Kreta\Component\User\Model\Interfaces\UserInterface;
use Kreta\Component\Workflow\Model\Interfaces\WorkflowInterface;
use Kreta\Component\Workflow\Model\Status;
use Kreta\Component\Workflow\Model\StatusTransition;

/**
 * Class WorkflowFactory.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
 */
class WorkflowFactory
{
    /**
     * The class name.
     *
     * @var string
     */
    protected $className;

    /**
     * Constructor.
     *
     * @param string $className The class name
     */
    public function __construct($className)
    {
        $this->className = $className;
    }

    /**
     * Creates an instance of workflow.
     *
     * @param string                                               $name The name
     * @param \Kreta\Component\User\Model\Interfaces\UserInterface $user The creator
     * @param boolean                                              $load Load boolean, by default false
     *
     * @return \Kreta\Component\Workflow\Model\Interfaces\WorkflowInterface
     */
    public function create($name, UserInterface $user, $load = false)
    {
        $workflow = new $this->className();

        if ($load) {
            $workflow = $this->loadInitialStatusesAndTransitions($workflow);
        }

        return $workflow
            ->setName($name)
            ->setCreator($user);
    }

    /**
     * Loads the default statuses and transitions.
     *
     * @param \Kreta\Component\Workflow\Model\Interfaces\WorkflowInterface $workflow The workflow
     *
     * @return \Kreta\Component\Workflow\Model\Interfaces\WorkflowInterface
     */
    protected function loadInitialStatusesAndTransitions(WorkflowInterface $workflow)
    {
        $statuses = $this->createDefaultStatus();
        foreach ($statuses as $status) {
            $status->setWorkflow($workflow);
            $workflow->addStatus($status);
        }
        $transitions = $this->createDefaultTransitions($statuses);
        foreach ($transitions as $transition) {
            $workflow->addStatusTransition($transition);
        }

        return $workflow;
    }

    /**
     * Creates some default statuses to add into workflow when this is created.
     *
     * @return \Kreta\Component\Workflow\Model\Interfaces\StatusInterface[]
     */
    protected function createDefaultStatus()
    {
        $defaultStatusesNames = ['To do', 'Doing', 'Done'];
        $statuses = [];
        foreach ($defaultStatusesNames as $name) {
            $statuses[$name] = new Status($name);
        }

        $statuses['To do']->setColor('#2c3e50');
        $statuses['To do']->setType('initial');

        $statuses['Doing']->setColor('#f1c40f');

        $statuses['Done']->setColor('#1abc9c');
        $statuses['Done']->setType('final');

        return $statuses;
    }

    /**
     * Creates some default transitions to add into workflow when this is created.
     *
     * @param \Kreta\Component\Workflow\Model\Interfaces\StatusInterface[] $statuses The status
     *
     * @return \Kreta\Component\Workflow\Model\Interfaces\StatusTransitionInterface[]
     */
    protected function createDefaultTransitions($statuses)
    {
        $defaultTransitions = [
            'Start progress'  => [
                'from' => [$statuses['To do']],
                'to'   => $statuses['Doing']
            ],
            'Finish progress' => [
                'from' => [$statuses['To do'], $statuses['Doing']],
                'to'   => $statuses['Done']
            ],
            'Stop progress'   => [
                'from' => [$statuses['Doing']],
                'to'   => $statuses['To do']
            ],
            'Reopen issue'    => [
                'from' => [$statuses['Done']],
                'to'   => $statuses['Doing']
            ],
        ];

        $transitions = [];

        foreach ($defaultTransitions as $transitionName => $defaultTransition) {
            $transition = new StatusTransition($transitionName, $defaultTransition['from'], $defaultTransition['to']);

            $transitions[] = $transition;
        }

        return $transitions;
    }
}
