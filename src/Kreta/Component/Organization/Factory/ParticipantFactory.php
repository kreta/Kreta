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

namespace Kreta\Component\Organization\Factory;

use Kreta\Component\Organization\Model\Interfaces\OrganizationInterface;
use Kreta\Component\Organization\Model\Interfaces\ParticipantInterface;
use Kreta\Component\User\Model\Interfaces\UserInterface;

/**
 * Organization participant factory.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
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
     * Creates an instance of an organization participant.
     *
     * @param OrganizationInterface $organization The organization
     * @param UserInterface         $user         The user
     * @param string                $role         The role assigned to the participant, by default ROLE_PARTICIPANT
     *
     * @return ParticipantInterface
     */
    public function create(
        OrganizationInterface $organization,
        UserInterface $user,
        $role = ParticipantInterface::ORG_PARTICIPANT
    ) {
        $participant = new $this->className($organization, $user);
        $participant->setRole($role);

        return $participant;
    }
}
