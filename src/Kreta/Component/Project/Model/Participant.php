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

namespace Kreta\Component\Project\Model;

use Kreta\Component\Organization\Model\Interfaces\OrganizationInterface;
use Kreta\Component\Project\Model\Interfaces\ParticipantInterface;
use Kreta\Component\Project\Model\Interfaces\ProjectInterface;
use Kreta\Component\User\Model\Interfaces\UserInterface;

/**
 * Class Project Role.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
 */
class Participant implements ParticipantInterface
{
    /**
     * The project.
     *
     * @var \Kreta\Component\Project\Model\Interfaces\ProjectInterface
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
     * @var \Kreta\Component\User\Model\Interfaces\UserInterface
     */
    protected $user;

    /**
     * Constructor.
     *
     * @param ProjectInterface $project The project
     * @param UserInterface    $user    The user
     */
    public function __construct(ProjectInterface $project, UserInterface $user)
    {
        $this->project = $project;
        $this->user = $user;
    }

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
        if ($project->getOrganization() instanceof OrganizationInterface) {
            $organizationParticipants = $project->getOrganization()->getParticipants();
            foreach ($organizationParticipants as $organizationParticipant) {
                if ($organizationParticipant->getUser()->getId() === $this->user->getId()) {
                    throw new \LogicException('The user is already a project\'s organization participant');
                }
            }
        }
        $project->addParticipant($this);
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
    public function setUser(UserInterface $user = null)
    {
        $this->user = $user;

        return $this;
    }
}
