<?php

/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Component\Project\Factory;

use Kreta\Component\Project\Model\Interfaces\ProjectInterface;
use Kreta\Component\User\Model\Interfaces\UserInterface;

/**
 * Class ParticipantFactory.
 *
 * @package Kreta\Component\Project\Factory
 */
class ParticipantFactory
{
    /**
     * The class name.
     *
     * @var string
     */
    protected $className;

    /**
     * Constructor.
     *
     * @param string $className The class name
     */
    public function __construct($className)
    {
        $this->className = $className;
    }

    /**
     * Creates an instance of an entity.
     *
     * @param \Kreta\Component\Project\Model\Interfaces\ProjectInterface $project The project
     * @param \Kreta\Component\User\Model\Interfaces\UserInterface       $user    The user
     * @param string                                                     $role    The role assigned to the participant
     *
     * @return \Kreta\Component\Project\Model\Interfaces\ParticipantInterface
     */
    public function create(ProjectInterface $project, UserInterface $user, $role = 'ROLE_PARTICIPANT')
    {
        $participant = new $this->className($project, $user);
        $participant->setRole($role);

        $project->addParticipant($participant);

        return $participant;
    }
}
