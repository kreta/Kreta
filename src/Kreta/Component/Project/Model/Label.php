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

use Kreta\Component\Core\Model\Abstracts\AbstractModel;
use Kreta\Component\Project\Model\Interfaces\LabelInterface;
use Kreta\Component\Project\Model\Interfaces\ProjectInterface;

/**
 * Class Label.
 *
 * @package Kreta\Component\Project\Model
 */
class Label extends AbstractModel implements LabelInterface
{
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
     * {@inheritdoc}
     */
    public function __toString()
    {
        return $this->name;
    }
}
