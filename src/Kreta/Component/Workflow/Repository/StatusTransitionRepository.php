<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Component\Workflow\Repository;

use Kreta\Component\Core\Repository\EntityRepository;
use Kreta\Component\Workflow\Model\Interfaces\StatusInterface;
use Kreta\Component\Workflow\Model\Interfaces\StatusTransitionInterface;

/**
 * Class StatusTransitionRepository.
 *
 * @package Kreta\Component\Workflow\Repository
 */
class StatusTransitionRepository extends EntityRepository
{
    /**
     * Persists the initial status of transition given if it is possible.
     *
     * @param \Kreta\Component\Workflow\Model\Interfaces\StatusTransitionInterface $transition    The transition
     * @param \Kreta\Component\Workflow\Model\Interfaces\StatusInterface           $initialStatus The initial status
     *
     * @return void
     */
    public function persistInitialStatus(StatusTransitionInterface $transition, StatusInterface $initialStatus)
    {
        $transition->addInitialState($initialStatus);
        $this->persist($transition);
    }

    /**
     * Removes the initial status of transition given if it is possible.
     *
     * @param \Kreta\Component\Workflow\Model\Interfaces\StatusTransitionInterface $transition      The transition
     * @param string                                                               $initialStatusId Initial status id
     *
     * @return void
     */
    public function removeInitialStatus(StatusTransitionInterface $transition, $initialStatusId)
    {
        $transition->removeInitialState($transition->getInitialState($initialStatusId));
        $this->persist($transition);
    }
}
