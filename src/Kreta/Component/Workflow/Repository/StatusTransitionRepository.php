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

namespace Kreta\Component\Workflow\Repository;

use Kreta\Component\Core\Repository\EntityRepository;
use Kreta\Component\Workflow\Model\Interfaces\StatusInterface;
use Kreta\Component\Workflow\Model\Interfaces\StatusTransitionInterface;

/**
 * Class StatusTransitionRepository.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
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
