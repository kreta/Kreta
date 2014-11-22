<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Component\Core\Model;

use Finite\Transition\Transition;
use Kreta\Component\Core\Model\Interfaces\ProjectInterface;
use Kreta\Component\Core\Model\Interfaces\StatusTransitionInterface;

/**
 * Class StatusTransition
 *
 * @package Kreta\Component\Core\Model
 */
class StatusTransition extends Transition implements StatusTransitionInterface
{
    /**
     * The id.
     *
     * @var string
     */
    protected $id;

    /**
     * The project.
     *
     * @var \Kreta\Component\Core\Model\Interfaces\ProjectInterface
     */
    protected $project;

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Sets id.
     *
     * @param $id
     *
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Gets project.
     *
     * @return \Kreta\Component\Core\Model\Interfaces\ProjectInterface
     */
    public function getProject()
    {
        return $this->project;
    }

    /**
     * Sets the project.
     *
     * @param \Kreta\Component\Core\Model\Interfaces\ProjectInterface $project The project
     *
     * @return $this self Object
     */
    public function setProject(ProjectInterface $project)
    {
        $this->project = $project;

        return $this;
    }
}
