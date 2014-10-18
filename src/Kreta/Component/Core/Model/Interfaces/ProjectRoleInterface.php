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

/**
 * Interface ProjectRoleInterface.
 *
 * @package Kreta\Component\Core\Model\Interfaces
 */
interface ProjectRoleInterface
{
    const ADMIN = 'ROLE_ADMIN';
    const PARTICIPANT = 'ROLE_PARTICIPANT';

    /**
     * Gets project.
     *
     * @return \Kreta\Component\Core\Model\Interfaces\ProjectInterface
     */
    public function getProject();

    /**
     * Sets project.
     *
     * @param \Kreta\Component\Core\Model\Interfaces\ProjectInterface $project The project
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
     * @return \Kreta\Component\Core\Model\Interfaces\UserInterface
     */
    public function getUser();

    /**
     * Sets user.
     *
     * @param \Kreta\Component\Core\Model\Interfaces\UserInterface $user The user
     *
     * @return $this self Object
     */
    public function setUser(UserInterface $user);
}
