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

namespace Kreta\Bundle\WorkflowBundle\Security\Authorization\Voter;

use Kreta\Bundle\CoreBundle\Security\Authorization\Voter\Abstracts\AbstractVoter;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class WorkflowVoter.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
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
    protected function checkAttribute(UserInterface $user, $workflow, $attribute)
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
