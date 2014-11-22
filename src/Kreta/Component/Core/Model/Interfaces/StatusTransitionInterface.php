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

use Finite\Transition\TransitionInterface;

/**
 * Class StatusTransition
 *
 * @package Kreta\Component\Core\Model
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
}
