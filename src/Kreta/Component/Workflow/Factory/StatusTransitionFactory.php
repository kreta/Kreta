<?php

/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Component\Workflow\Factory;

use Kreta\Component\Workflow\Model\Interfaces\StatusInterface;

/**
 * Class StatusTransitionFactory.
 *
 * @package Kreta\Component\Workflow\Factory
 */
class StatusTransitionFactory
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
     * Creates an instance of status transition.
     *
     * @param string                                                       $name          The name
     * @param \Kreta\Component\Workflow\Model\Interfaces\StatusInterface   $state         The state
     * @param \Kreta\Component\Workflow\Model\Interfaces\StatusInterface[] $initialStates Array that contains
     *                                                                                    initial statuses
     *
     * @return \Kreta\Component\Workflow\Model\Interfaces\StatusTransitionInterface
     */
    public function create($name, StatusInterface $state = null, array $initialStates = [])
    {
        return new $this->className($name, $initialStates, $state);
    }
}
