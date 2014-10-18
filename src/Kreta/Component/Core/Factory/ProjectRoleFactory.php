<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Component\Core\Factory;

use Kreta\Component\Core\Model\Interfaces\ProjectInterface;
use Kreta\Component\Core\Model\Interfaces\UserInterface;
use Kreta\Component\Core\Model\ProjectRole;

/**
 * Class ProjectRoleFactory.
 *
 * @package Kreta\Component\Core\Factory
 */
class ProjectRoleFactory
{
    /**
     * {@inheritdoc}
     */
    public function create(ProjectInterface $project, UserInterface $user)
    {
        return new ProjectRole($project, $user);
    }
}
