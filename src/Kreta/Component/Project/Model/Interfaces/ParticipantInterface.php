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
     * @param \Kreta\Component\User\Model\Interfaces\UserInterface|null $user The user
     *
     * @return $this self Object
     */
    public function setUser(UserInterface $user = null);
}
