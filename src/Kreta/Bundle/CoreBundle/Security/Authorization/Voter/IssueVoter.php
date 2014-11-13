<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Bundle\CoreBundle\Security\Authorization\Voter;

use Kreta\Bundle\CoreBundle\Security\Authorization\Voter\Abstracts\AbstractVoter;
use Kreta\Component\Core\Model\Participant;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class IssueVoter.
 *
 * @package Kreta\Bundle\CoreBundle\Security\Authorization\Voter
 */
class IssueVoter extends AbstractVoter
{
    const ASSIGN = 'assign';
    const DELETE = 'delete';
    const EDIT = 'edit';
    const VIEW = 'view';

    /**
     * {@inheritdoc}
     */
    protected $attributes = array(
        self::ASSIGN,
        self::DELETE,
        self::EDIT,
        self::VIEW
    );

    /**
     * {@inheritdoc}
     */
    protected $supportedClass = 'Kreta\Component\Core\Model\Interfaces\IssueInterface';

    /**
     * {@inheritdoc}
     */
    public function checkAttribute(UserInterface $user, $issue, $attribute)
    {
        switch ($attribute) {
            case self::ASSIGN:
            case self::DELETE:
            case self::EDIT:
                $participant = $issue->getProject()->getUserRole($user);

                if ($issue->isAssignee($user) === true
                    || $issue->isReporter($user) === true
                    || $participant === Participant::ADMIN
                ) {
                    return VoterInterface::ACCESS_GRANTED;
                }
                break;
            case self::VIEW:
                if ($issue->isParticipant($user) === true) {
                    return VoterInterface::ACCESS_GRANTED;
                }
                break;
        }

        return VoterInterface::ACCESS_DENIED;
    }
}
