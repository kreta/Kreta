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

use Finite\Transition\TransitionInterface;

/**
 * Interface StatusTransitionInterface.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
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
     * Gets the initial status of id given.
     *
     * @param string $initialStatusId The initial status id
     *
     * @throws \Kreta\Component\Core\Exception\CollectionMinLengthException
     * @throws \Doctrine\ORM\NoResultException
     *
     * @return \Kreta\Component\Workflow\Model\Interfaces\StatusInterface
     */
    public function getInitialState($initialStatusId);

    /**
     * Adds initial status.
     *
     * @param \Kreta\Component\Workflow\Model\Interfaces\StatusInterface $status The status
     *
     * @throws \InvalidArgumentException
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Kreta\Component\Core\Exception\ResourceAlreadyPersistException
     *
     * @return $this self Object
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

    /**
     * Gets workflow.
     *
     * @return \Kreta\Component\Workflow\Model\Interfaces\WorkflowInterface
     */
    public function getWorkflow();

    /**
     * Checks if the transition is in use by any issue.
     *
     * @return bool
     */
    public function isInUse();
}
