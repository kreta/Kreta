<?php

/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Bundle\TimeTrackingBundle\Security\Authorization\Voter;

use Kreta\Bundle\CoreBundle\Security\Authorization\Voter\Abstracts\AbstractVoter;
use Kreta\Component\Project\Model\Participant;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class TimeEntryVoter.
 *
 * @package Kreta\Bundle\TimeTrackingBundle\Security\Authorization\Voter
 */
class TimeEntryVoter extends AbstractVoter
{
    const CREATE = 'create';
    const DELETE = 'delete';
    const EDIT = 'edit';
    const VIEW = 'view';

    /**
     * {@inheritdoc}
     */
    protected $attributes = [
        self::CREATE,
        self::DELETE,
        self::EDIT,
        self::VIEW
    ];

    /**
     * {@inheritdoc}
     */
    protected $supportedClass = 'Kreta\Component\TimeTracking\Model\Interfaces\TimeEntryInterface';

    /**
     * {@inheritdoc}
     */
    public function checkAttribute(UserInterface $user, $timeEntry, $attribute)
    {
        $issue = $timeEntry->getIssue();
        switch ($attribute) {
            case self::CREATE:
            case self::DELETE:
            case self::EDIT:
                $participant = $issue->getProject()->getUserRole($user);

                if ($issue->isAssignee($user) || $issue->isReporter($user) || $participant === Participant::ADMIN) {
                    return VoterInterface::ACCESS_GRANTED;
                }
                break;
            case self::VIEW:
                if ($issue->isParticipant($user)) {
                    return VoterInterface::ACCESS_GRANTED;
                }
                break;
        }

        return VoterInterface::ACCESS_DENIED;
    }
}
