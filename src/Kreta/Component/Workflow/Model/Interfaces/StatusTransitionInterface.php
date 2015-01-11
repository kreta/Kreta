<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Component\Workflow\Model\Interfaces;

use Finite\Transition\TransitionInterface;

/**
 * Interface StatusTransitionInterface.
 *
 * @package Kreta\Component\Workflow\Model\Interfaces
 */
interface StatusTransitionInterface extends TransitionInterface
{
    /**
     * Gets id.
     *
     * @return string
     */
    public function getId();

    /**
     * Gets workflow.
     *
     * @return \Kreta\Component\Workflow\Model\Interfaces\WorkflowInterface
     */
    public function getWorkflow();

    /**
     * Gets the initial status of id given.
     *
     * @param string $initialStatusId The initial status id
     *
     * @return \Kreta\Component\Workflow\Model\Interfaces\StatusInterface
     * @throws \Kreta\Component\Core\Exception\CollectionMinLengthException
     * @throws \Doctrine\ORM\NoResultException
     */
    public function getInitialState($initialStatusId);

    /**
     * Adds initial status.
     *
     * @param \Kreta\Component\Workflow\Model\Interfaces\StatusInterface $status The status
     *
     * @return $this self Object
     * @throws \InvalidArgumentException
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Kreta\Component\Core\Exception\ResourceAlreadyPersistException
     */
    public function addInitialState($status);

    /**
     * Removes initial status.
     *
     * @param \Kreta\Component\Workflow\Model\Interfaces\StatusInterface $status The status
     *
     * @return $this self Object
     */
    public function removeInitialState(StatusInterface $status);
}
