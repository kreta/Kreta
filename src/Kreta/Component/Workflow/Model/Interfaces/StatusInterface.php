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

namespace Kreta\Component\Workflow\Model\Interfaces;

use Finite\State\StateInterface;

/**
 * Interface StatusInterface.
 *
 * @package Kreta\Component\Workflow\Model\Interfaces
 */
interface StatusInterface extends StateInterface
{
    /**
     * Gets id.
     *
     * @return string
     */
    public function getId();

    /**
     * Gets color.
     *
     * @return string
     */
    public function getColor();

    /**
     * Sets color.
     *
     * @param string $color The color
     *
     * @return $this self Object
     */
    public function setColor($color);

    /**
     * Sets name.
     *
     * @param string $name The name
     *
     * @return $this self Object
     */
    public function setName($name);

    /**
     * Sets type.
     *
     * @param string $type The type
     *
     * @return $this self Object
     */
    public function setType($type);

    /**
     * Gets workflow.
     *
     * @return \Kreta\Component\Workflow\Model\Interfaces\WorkflowInterface
     */
    public function getWorkflow();

    /**
     * Sets workflow.
     *
     * @param \Kreta\Component\Workflow\Model\Interfaces\WorkflowInterface $workflow The workflow
     *
     * @return $this self Object
     */
    public function setWorkflow(WorkflowInterface $workflow);

    /**
     * Checks if the status is in use by any issue.
     *
     * @return boolean
     */
    public function isInUse();
}
