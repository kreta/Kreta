<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Component\Core\Factory;

use Kreta\Component\Core\Model\Status;
use Kreta\Component\Core\Model\StatusTransition;

/**
 * Class ProjectFactory.
 *
 * @package Kreta\Component\Core\Factory
 */
class ProjectFactory
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
     * Creates an instance of an entity.
     *
     * @return \Kreta\Component\Core\Model\Interfaces\ProjectInterface
     */
    public function create()
    {
        /** @var $project \Kreta\Component\Core\Model\Interfaces\ProjectInterface */
        $project = new $this->className();
        $statuses = $this->createDefaultStatus();
        foreach ($statuses as $status) {
            $status->setProject($project);
            $project->addStatus($status);
        }
        $transitions = $this->createDefaultTransitions($statuses);
        foreach ($transitions as $transition) {
            $transition->setProject($project);
            $project->addStatusTransition($transition);
        }

        return $project;
    }

    /**
     * Creates some default statuses to add into project when this is created.
     *
     * @return \Kreta\Component\Core\Model\Interfaces\StatusInterface[]
     */
    protected function createDefaultStatus()
    {
        $defaultStatusesNames = array('To do', 'Doing', 'Done');

        $statuses = array();
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
     * Creates some default transitions to add into project when this is created.
     *
     * @param \Kreta\Component\Core\Model\Interfaces\StatusInterface[] $statuses
     *
     * @return \Kreta\Component\Core\Model\Interfaces\StatusTransitionInterface[]
     */
    protected function createDefaultTransitions($statuses)
    {
        $defaultTransitions = [
            'Start progress' => [
                'from' => [$statuses['To do']],
                'to' => $statuses['Doing']
            ],
            'Finish progress' => [
                'from' => [$statuses['To do'], $statuses['Doing']],
                'to' => $statuses['Done']
            ],
            'Stop progress' => [
                'from' => [$statuses['Doing']],
                'to' => $statuses['To do']
            ],
            'Reopen issue' => [
                'from' => [$statuses['Done']],
                'to' => $statuses['Doing']
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
