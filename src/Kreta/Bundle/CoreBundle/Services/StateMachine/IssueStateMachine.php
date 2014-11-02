<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Bundle\CoreBundle\Services\StateMachine;

use Finite\Loader\ArrayLoader;
use Finite\StateMachine\StateMachine;
use Kreta\Component\Core\Model\Interfaces\IssueInterface;

/**
 * Class IssueStateMachine.
 *
 * @package Kreta\Bundle\CoreBundle\Services\StateMachine
 */
class IssueStateMachine extends StateMachine
{
    /**
     * The statuses
     *
     * @var \Kreta\Component\Core\Model\Interfaces\StatusInterface[]
     */
    protected $statuses;

    /**
     * Loads a issue state machine.
     *
     * @param \Kreta\Component\Core\Model\Interfaces\IssueInterface    $issue    The issue
     * @param \Kreta\Component\Core\Model\Interfaces\StatusInterface[] $statuses A collection of statuses
     *
     * @return $this self Object
     */
    public function load(IssueInterface $issue, $statuses)
    {
        $this->statuses = $statuses;

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
        return new ArrayLoader([
            'class'         => 'Issue',
            'property_path' => 'status',
            'states'        => $this->getStates(),
            'transitions'   => $this->getTransitions()
        ]);
    }

    /**
     * Gets array that contains all the states of project.
     *
     * @return array
     */
    public function getStates()
    {
        $statusCollection = $this->statuses;

        $states = array();
        foreach ($statusCollection as $status) {
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
        $statusCollection = $this->statuses;

        $transitions = array();
        foreach ($statusCollection as $status) {
            foreach ($status->getTransitions() as $transition) {
                $transitions[$status->getName() . '-' . $transition->getName()] =
                    ['from' => [$status->getName()], 'to' => $transition->getName()];
            }
        }

        return $transitions;
    }
}
