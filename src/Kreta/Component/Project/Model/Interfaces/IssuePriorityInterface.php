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

namespace Kreta\Component\Project\Model\Interfaces;

/**
 * Interface IssuePriorityInterface.
 *
 * @package Kreta\Component\Project\Model\Interfaces
 */
interface IssuePriorityInterface
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
     * Gets project.
     *
     * @return \Kreta\Component\Project\Model\Interfaces\ProjectInterface
     */
    public function getProject();

    /**
     * Sets the project.
     *
     * @param \Kreta\Component\Project\Model\Interfaces\ProjectInterface $project The project
     *
     * @return $this self Object
     */
    public function setProject(ProjectInterface $project);
}
