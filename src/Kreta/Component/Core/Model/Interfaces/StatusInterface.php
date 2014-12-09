<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Component\Core\Model\Interfaces;

use Finite\State\StateInterface;

/**
 * Interface StatusInterface.
 *
 * @package Kreta\Component\Core\Model\Interfaces
 */
interface StatusInterface extends StateInterface
{
    /**
     * Sets id.
     *
     * @param string $id The id
     *
     * @return $this self Object
     */
    public function setId($id);

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
     * Sets description.
     *
     * @param string $name The name
     *
     * @return $this self Object
     */
    public function setName($name);

    /**
     * Gets project.
     *
     * @return \Kreta\Component\Core\Model\Interfaces\ProjectInterface
     */
    public function getProject();

    /**
     * Sets the project.
     *
     * @param \Kreta\Component\Core\Model\Interfaces\ProjectInterface $project The project
     *
     * @return $this self Object
     */
    public function setProject(ProjectInterface $project);

    /**
     * Sets type.
     *
     * @param string $type The type that can be 0 (initial), 1 (normal) or 2 (final)
     *
     * @return $this self Object
     */
    public function setType($type);
}
