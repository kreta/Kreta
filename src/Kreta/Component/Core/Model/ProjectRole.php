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

use Kreta\Component\Core\Model\Interfaces\ProjectInterface;
use Kreta\Component\Core\Model\Interfaces\ProjectRoleInterface;
use Kreta\Component\Core\Model\Interfaces\UserInterface;

/**
 * Class Project Role.
 *
 * @package Kreta\Component\Core\Model
 */
class ProjectRole implements ProjectRoleInterface
{
    /**
     * The project.
     *
     * @var \Kreta\Component\Core\Model\Interfaces\ProjectInterface
     */
    protected $project;

    /**
     * The role.
     *
     * @var string
     */
    protected $role;

    /**
     * The user.
     *
     * @var \Kreta\Component\Core\Model\Interfaces\UserInterface
     */
    protected $user;

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
    public function getRole()
    {
        return $this->role;
    }

    /**
     * {@inheritdoc}
     */
    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * {@inheritdoc}
     */
    public function setUser(UserInterface $user)
    {
        $this->user = $user;

        return $this;
    }
}
