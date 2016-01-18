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

use Kreta\Component\Workflow\Model\Interfaces\StatusInterface;

/**
 * Class StatusTransitionFactory.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
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
