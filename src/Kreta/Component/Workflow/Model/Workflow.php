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

namespace Kreta\Component\Workflow\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Kreta\Component\Core\Model\Abstracts\AbstractModel;
use Kreta\Component\Project\Model\Interfaces\ProjectInterface;
use Kreta\Component\User\Model\Interfaces\UserInterface;
use Kreta\Component\Workflow\Model\Interfaces\StatusInterface;
use Kreta\Component\Workflow\Model\Interfaces\StatusTransitionInterface;
use Kreta\Component\Workflow\Model\Interfaces\WorkflowInterface;

/**
 * Class Workflow.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
 */
class Workflow extends AbstractModel implements WorkflowInterface
{
    /**
     * The created at.
     *
     * @var \DateTime
     */
    protected $createdAt;

    /**
     * The creator.
     *
     * @var \Kreta\Component\User\Model\Interfaces\UserInterface
     */
    protected $creator;

    /**
     * The name.
     *
     * @var string
     */
    protected $name;

    /**
     * Array which contains the projects.
     *
     * @var \Kreta\Component\Project\Model\Interfaces\ProjectInterface[]
     */
    protected $projects;

    /**
     * Array which contains the statuses.
     *
     * @var \Kreta\Component\Workflow\Model\Interfaces\StatusInterface[]
     */
    protected $statuses;

    /**
     * Array which contains the status transition.
     *
     * @var \Kreta\Component\Workflow\Model\Interfaces\StatusTransitionInterface[]
     */
    protected $statusTransitions;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->projects = new ArrayCollection();
        $this->statuses = new ArrayCollection();
        $this->statusTransitions = new ArrayCollection();
    }

    /**
     * {@inheritdoc}
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * {@inheritdoc}
     */
    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getCreator()
    {
        return $this->creator;
    }

    /**
     * {@inheritdoc}
     */
    public function setCreator(UserInterface $creator)
    {
        $this->creator = $creator;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * {@inheritdoc}
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getProjects()
    {
        return $this->projects;
    }

    /**
     * {@inheritdoc}
     */
    public function addProject(ProjectInterface $project)
    {
        $this->projects[] = $project;

        return $this;
    }


    /**
     * {@inheritdoc}
     */
    public function removeProject(ProjectInterface $project)
    {
        $this->projects->removeElement($project);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getStatuses()
    {
        return $this->statuses;
    }

    /**
     * {@inheritdoc}
     */
    public function addStatus(StatusInterface $status)
    {
        $this->statuses[] = $status;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function removeStatus(StatusInterface $status)
    {
        $this->statuses->removeElement($status);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getStatusTransitions()
    {
        return $this->statusTransitions;
    }

    /**
     * {@inheritdoc}
     */
    public function addStatusTransition(StatusTransitionInterface $statusTransition)
    {
        $this->statusTransitions[] = $statusTransition;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function removeStatusTransition(StatusTransitionInterface $statusTransition)
    {
        $this->statusTransitions->removeElement($statusTransition);

        return $this;
    }
}
