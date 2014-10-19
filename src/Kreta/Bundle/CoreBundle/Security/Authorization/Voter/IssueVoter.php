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

use Kreta\Component\Core\Model\Participant;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class IssueVoter.
 *
 * @package Kreta\Bundle\CoreBundle\Security\Authorization\Voter
 */
class IssueVoter implements VoterInterface
{
    const ASSIGN = 'assign';
    const EDIT = 'edit';
    const VIEW = 'view';

    /**
     * {@inheritdoc}
     */
    public function supportsAttribute($attribute)
    {
        return in_array($attribute, array(
            self::ASSIGN,
            self::EDIT,
            self::VIEW,
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function supportsClass($class)
    {
        $supportedClass = 'Kreta\Component\Core\Model\Interfaces\IssueInterface';

        return $supportedClass === $class || is_subclass_of($class, $supportedClass);
    }

    /**
     * {@inheritdoc}
     */
    public function vote(TokenInterface $token, $issue, array $attributes)
    {
        if ($this->supportsClass(get_class($issue)) === false) {
            return VoterInterface::ACCESS_ABSTAIN;
        }

        if (count($attributes) !== 1) {
            throw new \InvalidArgumentException('Only one attribute allowed.');
        }

        $attribute = $attributes[0];

        if ($this->supportsAttribute($attribute) === false) {
            return VoterInterface::ACCESS_ABSTAIN;
        }

        $user = $token->getUser();
        if (($user instanceof UserInterface) === false) {
            return VoterInterface::ACCESS_DENIED;
        }

        switch ($attribute) {
            case self::ASSIGN:
            case self::EDIT:
                $participant = $issue->getProject()->getUserRole($user);

                if ($issue->isAssignee($user) === true
                    || $issue->isReporter($user) === true
                    || $participant == Participant::ADMIN
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
