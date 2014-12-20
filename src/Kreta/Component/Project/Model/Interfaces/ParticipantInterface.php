<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Component\Project\Model\Interfaces;

use Kreta\Component\User\Model\Interfaces\UserInterface;

/**
 * Interface ParticipantInterface.
 *
 * @package Kreta\Component\Project\Model\Interfaces
 */
interface ParticipantInterface
{
    const ADMIN = 'ROLE_ADMIN';
    const PARTICIPANT = 'ROLE_PARTICIPANT';

    /**
     * Gets project.
     *
     * @return \Kreta\Component\Project\Model\Interfaces\ProjectInterface
     */
    public function getProject();

    /**
     * Sets project.
     *
     * @param \Kreta\Component\Project\Model\Interfaces\ProjectInterface $project The project
     *
     * @return $this self Object
     */
    public function setProject(ProjectInterface $project);

    /**
     * Gets role.
     *
     * @return string
     */
    public function getRole();

    /**
     * Sets role.
     *
     * @param string $role The role
     *
     * @return $this self Object
     */
    public function setRole($role);

    /**
     * Gets user.
     *
     * @return \Kreta\Component\User\Model\Interfaces\UserInterface
     */
    public function getUser();

    /**
     * Sets user.
     *
     * @param \Kreta\Component\User\Model\Interfaces\UserInterface $user The user
     *
     * @return $this self Object
     */
    public function setUser(UserInterface $user);
}
