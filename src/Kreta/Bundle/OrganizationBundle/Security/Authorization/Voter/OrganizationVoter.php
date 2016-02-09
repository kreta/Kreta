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

namespace Kreta\Bundle\OrganizationBundle\Security\Authorization\Voter;

use Kreta\Bundle\CoreBundle\Security\Authorization\Voter\Abstracts\AbstractVoter;
use Kreta\Component\Organization\Model\Interfaces\ParticipantInterface;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Organization voter class.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 */
class OrganizationVoter extends AbstractVoter
{
    const ADD_PARTICIPANT = 'add_participant';
    const CREATE_PROJECT = 'create_project';
    const DELETE = 'delete';
    const DELETE_PARTICIPANT = 'delete_participant';
    const EDIT_ROLE_PARTICIPANT = 'edit_role_participant';
    const EDIT = 'edit';
    const VIEW = 'view';

    /**
     * {@inheritdoc}
     */
    protected $attributes = [
        self::ADD_PARTICIPANT,
        self::CREATE_PROJECT,
        self::DELETE,
        self::DELETE_PARTICIPANT,
        self::EDIT_ROLE_PARTICIPANT,
        self::EDIT,
        self::VIEW,
    ];

    /**
     * {@inheritdoc}
     */
    protected $supportedClass = 'Kreta\Component\Organization\Model\Interfaces\OrganizationInterface';

    /**
     * {@inheritdoc}
     */
    protected function checkAttribute(UserInterface $user, $organization, $attribute)
    {
        switch ($attribute) {
            case self::ADD_PARTICIPANT:
            case self::DELETE:
            case self::DELETE_PARTICIPANT:
            case self::EDIT_ROLE_PARTICIPANT:
            case self::EDIT:
                if ($organization->getUserRole($user) === ParticipantInterface::ORG_ADMIN) {
                    return VoterInterface::ACCESS_GRANTED;
                }
                break;
            case self::VIEW:
            case self::CREATE_PROJECT:
                if ($organization->getUserRole($user) !== null) {
                    return VoterInterface::ACCESS_GRANTED;
                }
                break;
        }

        return VoterInterface::ACCESS_DENIED;
    }
}
