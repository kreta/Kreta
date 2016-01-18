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

namespace Kreta\Component\Issue\StateMachine;

use Finite\Loader\ArrayLoader;
use Finite\StateMachine\StateMachine;
use Kreta\Component\Issue\Model\Interfaces\IssueInterface;

/**
 * Class IssueStateMachine.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
 */
class IssueStateMachine extends StateMachine
{
    /**
     * The statuses.
     *
     * @var \Kreta\Component\Workflow\Model\Interfaces\StatusInterface[]
     */
    protected $statuses;

    /**
     * The transitions.
     *
     * @var \Kreta\Component\Workflow\Model\Interfaces\StatusTransitionInterface[]
     */
    protected $transitions;

    /**
     * Loads a issue state machine.
     *
     * @param \Kreta\Component\Issue\Model\Interfaces\IssueInterface                 $issue       The issue
     * @param \Kreta\Component\Workflow\Model\Interfaces\StatusInterface[]           $statuses    A collection of
     *                                                                                            statuses
     * @param \Kreta\Component\Workflow\Model\Interfaces\StatusTransitionInterface[] $transitions A collection of
     *                                                                                            transitions
     *
     * @return $this self Object
     */
    public function load(IssueInterface $issue, $statuses, $transitions)
    {
        $this->statuses = $statuses;
        $this->transitions = $transitions;

        parent::__construct($issue, null);

        $this->createLoader()->load($this);
        $this->initialize();

        return $this;
    }

    /**
     * Creates array loader.
     *
     * @return \Finite\Loader\ArrayLoader
     */
    private function createLoader()
    {
        return new ArrayLoader(
            [
                'class'         => 'Issue',
                'property_path' => 'status',
                'states'        => $this->getStates(),
                'transitions'   => $this->getTransitions(),
            ]
        );
    }

    /**
     * Gets array that contains all the states of project.
     *
     * @return array
     */
    public function getStates()
    {
        $states = [];

        foreach ($this->statuses as $status) {
            $states[$status->getName()] = ['type' => $status->getType()];
        }

        return $states;
    }

    /**
     * Gets array that contains all the transitions of states.
     *
     * @return array
     */
    public function getTransitions()
    {
        $transitions = [];

        foreach ($this->transitions as $transition) {
            $from = [];
            foreach ($transition->getInitialStates() as $state) {
                $from[] = $state->getName();
            }

            $transitions[$transition->getName()] = [
                'from' => $from,
                'to'   => $transition->getState()->getName()
            ];
        }

        return $transitions;
    }
}
