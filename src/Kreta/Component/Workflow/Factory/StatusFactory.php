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
use Kreta\Component\Workflow\Model\Interfaces\WorkflowInterface;

/**
 * Class StatusFactory.
 *
 * @package Kreta\Component\Workflow\Factory
 */
class StatusFactory
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
     * Creates an instance of status.
     *
     * @param string                                                       $name        The name
     * @param \Kreta\Component\Workflow\Model\Interfaces\WorkflowInterface $workflow    The workflow
     * @param string                                                       $type        The type
     * @param array                                                        $transitions Array that contains transitions
     * @param array                                                        $properties  Array that contains properties
     *
     * @return \Kreta\Component\Workflow\Model\Interfaces\StatusInterface
     */
    public function create(
        $name,
        WorkflowInterface $workflow,
        $type = StatusInterface::TYPE_NORMAL,
        array $transitions = [],
        array $properties = []
    )
    {
        $status = new $this->className($name, $type, $transitions, $properties);

        return $status
            ->setWorkflow($workflow);
    }
}
