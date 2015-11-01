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

namespace Kreta\Component\Project\Model;

use Kreta\Component\Project\Model\Interfaces\IssuePriorityInterface;
use Kreta\Component\Project\Model\Interfaces\ProjectInterface;

/**
 * Class IssuePriority.
 *
 * @package Kreta\Component\Project\Model
 */
class IssuePriority implements IssuePriorityInterface
{
    /**
     * The id.
     *
     * @var string
     */
    protected $id;

    /**
     * The name.
     *
     * @var string
     */
    protected $name;

    /**
     * The project.
     *
     * @var \Kreta\Component\Project\Model\Interfaces\ProjectInterface
     */
    protected $project;

    /**
     * Gets id.
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getProject()
    {
        return $this->project;
    }

    /**
     * {@inheritdoc}
     */
    public function setProject(ProjectInterface $project)
    {
        $this->project = $project;

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
     * Magic method that represents the priority into string.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->id;
    }
}
