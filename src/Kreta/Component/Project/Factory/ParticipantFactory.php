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

namespace Kreta\Component\Project\Factory;

use Kreta\Component\Project\Model\Interfaces\ProjectInterface;
use Kreta\Component\User\Model\Interfaces\UserInterface;

/**
 * Class ParticipantFactory.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
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

        return $participant;
    }
}
