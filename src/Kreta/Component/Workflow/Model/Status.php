<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Component\Workflow\Model;

use Finite\State\State;
use Kreta\Component\Workflow\Model\Interfaces\StatusInterface;
use Kreta\Component\Workflow\Model\Interfaces\WorkflowInterface;

/**
 * Class Status.
 *
 * @package Kreta\Component\Workflow\Model
 */
class Status extends State implements StatusInterface
{
    /**
     * The id.
     *
     * @var string
     */
    protected $id;

    /**
     * The color.
     *
     * @var string
     */
    protected $color;

    /**
     * {@inheritdoc}
     */
    protected $name;

    /**
     * {@inheritdoc}
     */
    protected $type;

    /**
     * The workflow.
     *
     * @var \Kreta\Component\Workflow\Model\Interfaces\WorkflowInterface
     */
    protected $workflow;

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * {@inheritdoc}
     */
    public function setColor($color)
    {
        $this->color = $color;

        return $this;
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
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getWorkflow()
    {
        return $this->workflow;
    }

    /**
     * {@inheritdoc}
     */
    public function setWorkflow(WorkflowInterface $workflow)
    {
        $this->workflow = $workflow;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function isInUse()
    {
        foreach ($this->getWorkflow()->getProjects() as $project) {
            foreach ($project->getIssues() as $issue) {
                if ($issue->getStatus()->getId() === $this->id) {
                    return true;
                }
            }
        }

        return false;
    }
}
