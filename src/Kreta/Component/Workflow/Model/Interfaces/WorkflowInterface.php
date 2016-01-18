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

use Kreta\Component\Project\Model\Interfaces\ProjectInterface;
use Kreta\Component\User\Model\Interfaces\UserInterface;

/**
 * Interface WorkflowInterface.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
 */
interface WorkflowInterface
{
    /**
     * Gets id.
     *
     * @return string
     */
    public function getId();

    /**
     * Gets created at.
     *
     * @return \DateTime
     */
    public function getCreatedAt();

    /**
     * Sets created at.
     *
     * @param \DateTime $createdAt The created at.
     *
     * @return $this self Object
     */
    public function setCreatedAt(\DateTime $createdAt);

    /**
     * Gets creator.
     *
     * @return \Kreta\Component\User\Model\Interfaces\UserInterface
     */
    public function getCreator();

    /**
     * Sets creator.
     *
     * @param \Kreta\Component\User\Model\Interfaces\UserInterface $creator The creator.
     *
     * @return $this self Object
     */
    public function setCreator(UserInterface $creator);

    /**
     * Gets name.
     *
     * @return string
     */
    public function getName();

    /**
     * Sets name.
     *
     * @param string $name The name
     *
     * @return $this self Object
     */
    public function setName($name);

    /**
     * Gets projects.
     *
     * @return \Kreta\Component\Project\Model\Interfaces\ProjectInterface[]
     */
    public function getProjects();

    /**
     * Adds project.
     *
     * @param \Kreta\Component\Project\Model\Interfaces\ProjectInterface $project The project
     *
     * @return $this self Object
     */
    public function addProject(ProjectInterface $project);

    /**
     * Removes project.
     *
     * @param \Kreta\Component\Project\Model\Interfaces\ProjectInterface $project The project
     *
     * @return $this self Object
     */
    public function removeProject(ProjectInterface $project);

    /**
     * Gets statuses.
     *
     * @return \Kreta\Component\Workflow\Model\Interfaces\StatusInterface[]
     */
    public function getStatuses();

    /**
     * Adds status.
     *
     * @param \Kreta\Component\Workflow\Model\Interfaces\StatusInterface $status The status
     *
     * @return $this self Object
     */
    public function addStatus(StatusInterface $status);

    /**
     * Removes status.
     *
     * @param \Kreta\Component\Workflow\Model\Interfaces\StatusInterface $status The status
     *
     * @return $this self Object
     */
    public function removeStatus(StatusInterface $status);

    /**
     * Gets status transitions.
     *
     * @return \Kreta\Component\Workflow\Model\Interfaces\StatusTransitionInterface[]
     */
    public function getStatusTransitions();

    /**
     * Adds status transition.
     *
     * @param \Kreta\Component\Workflow\Model\Interfaces\StatusTransitionInterface $statusTransition The status
     *                                                                                               transition
     *
     * @return $this self Object
     */
    public function addStatusTransition(StatusTransitionInterface $statusTransition);

    /**
     * Removes status transition.
     *
     * @param \Kreta\Component\Workflow\Model\Interfaces\StatusTransitionInterface $statusTransition The status
     *
     * @return $this self Object
     */
    public function removeStatusTransition(StatusTransitionInterface $statusTransition);
}
