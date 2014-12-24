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

use Kreta\Component\Core\Repository\Abstracts\AbstractRepository;
use Kreta\Component\Workflow\Model\Interfaces\WorkflowInterface;

/**
 * Class StatusTransitionRepository.
 *
 * @package Kreta\Component\Workflow\Repository
 */
class StatusTransitionRepository extends AbstractRepository
{
    /**
     * Finds the transitions of workflow given.
     *
     * @param \Kreta\Component\Workflow\Model\Interfaces\WorkflowInterface $workflow The workflow
     *
     * @return \Kreta\Component\Workflow\Model\Interfaces\StatusInterface[]
     */
    public function findByWorkflow(WorkflowInterface $workflow)
    {
        $queryBuilder = $this->createQueryBuilder('s');

        return $queryBuilder
            ->where($queryBuilder->expr()->eq('s.workflow', ':workflow'))
            ->setParameter('workflow', $workflow)
            ->getQuery()->getResult();
    }
}
