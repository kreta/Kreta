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
use Kreta\Component\Core\Model\Participant;

/**
 * Class ParticipantFactory.
 *
 * @package Kreta\Component\Core\Factory
 */
class ParticipantFactory
{
    /**
     * {@inheritdoc}
     */
    public function create(ProjectInterface $project, UserInterface $user)
    {
        return new Participant($project, $user);
    }
}
