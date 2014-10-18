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
    const ASSIGNEE = 'assignee';
    const EDIT = 'edit';
    const VIEW = 'view';

    /**
     * {@inheritdoc}
     */
    public function supportsAttribute($attribute)
    {
        return in_array($attribute, array(
            self::ASSIGNEE,
            self::EDIT,
            self::VIEW,
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function supportsClass($class)
    {
        $supportedClass = 'Kreta/Component/Core/Model/Issue';

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

        if (1 !== count($attributes)) {
            throw new \InvalidArgumentException('Only one attribute is allowed for ASSIGNEE, VIEW or EDIT');
        }

        $attribute = $attributes[0];

        if ($this->supportsAttribute($attribute) === false) {
            return VoterInterface::ACCESS_ABSTAIN;
        }

        $user = $token->getUser();
        if (($user instanceof UserInterface) === false) {
            return VoterInterface::ACCESS_DENIED;
        }
        
        $projectRoles = $user->getProjectRoles();
        $projectRolesLength = count($user->getProjectRoles());
        $i = 0;
        $projectRole = null;
        while ($i < $projectRolesLength) {
             if ($projectRoles[$i]->getProject()->getId() === $issue->getProject()->getId()) {
                 $projectRole = $projectRoles[$i];
             }
        }

        switch ($attribute) {
            case self::ASSIGNEE:
                if ($user->getId() === $issue->getAssignee()->getId()
                    || $user->getId() === $issue->getReporter()->getId()
                    || $issue->getProject()->getId === $projectRole->getProject()->getId()
                ) {
                    return VoterInterface::ACCESS_GRANTED;
                }
            case self::EDIT:
                if ($user->getId() === $issue->getAssignee()->getId()
                    || $user->getId() === $issue->getReporter()->getId()
                    || $issue->getProject()->getId === $projectRole->getProject()->getId()
                ) {
                    return VoterInterface::ACCESS_GRANTED;
                }
                break;
            case self::VIEW:
                foreach ($issue->getProject()->getParticipants() as $participant) {
                    if ($user->getId() === $participant) {
                        return VoterInterface::ACCESS_GRANTED;
                    }
                }
                break;
        }

        return VoterInterface::ACCESS_DENIED;
    }
}
