<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Bundle\WorkflowBundle\Security\Authorization\Voter;

use Kreta\Bundle\CoreBundle\Security\Authorization\Voter\Abstracts\AbstractVoter;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class WorkflowVoter.
 *
 * @package Kreta\Bundle\WorkflowBundle\Security\Authorization\Voter
 */
class WorkflowVoter extends AbstractVoter
{
    const EDIT = 'edit';
    const VIEW = 'view';
    const MANAGE_STATUS = 'manage_status';

    /**
     * {@inheritdoc}
     */
    protected $attributes = [
        self::EDIT,
        self::VIEW,
        self::MANAGE_STATUS
    ];

    /**
     * {@inheritdoc}
     */
    protected $supportedClass = 'Kreta\Component\Workflow\Model\Interfaces\WorkflowInterface';

    /**
     * {@inheritdoc}
     */
    public function checkAttribute(UserInterface $user, $workflow, $attribute)
    {
        switch ($attribute) {
            case self::EDIT:
            case self::MANAGE_STATUS:
                if ($workflow->getCreator()->getId() === $user->getId()) {
                    return VoterInterface::ACCESS_GRANTED;
                }
                break;
            case self::VIEW:
                if ($projects = $workflow->getProjects()) {
                    foreach ($projects as $project) {
                        if ($project->getUserRole($user) !== null) {
                            return VoterInterface::ACCESS_GRANTED;
                        }
                    }
                }
        }

        return VoterInterface::ACCESS_DENIED;
    }
}
