<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Component\Project\Repository;

use Kreta\Component\Core\Repository\Abstracts\AbstractRepository;
use Kreta\Component\User\Model\Interfaces\UserInterface;
use Kreta\Component\Workflow\Model\Interfaces\WorkflowInterface;

/**
 * Class ProjectRepository.
 *
 * @package Kreta\Component\Project\Repository
 */
class ProjectRepository extends AbstractRepository
{
    /**
     * Finds all the projects of participant given and ordered by value given.
     *
     * Can do pagination if $page is changed, starting from 0
     * and it can limit the search if $count is changed.
     *
     * @param \Kreta\Component\User\Model\Interfaces\UserInterface $participant The participant
     * @param string                                               $order       The order value
     * @param string|int                                           $count       The number of results
     * @param int                                                  $page        The number of page
     *
     * @return \Kreta\Component\Project\Model\Interfaces\ProjectInterface[]
     */
    public function findByParticipant(UserInterface $participant, $order = 'name', $count = 10, $page = 0)
    {
        $order = 'p.' . $order;

        $queryBuilder = $this->createQueryBuilder('p');

        $queryBuilder
            ->leftJoin('p.participants', 'pu')
            ->where($queryBuilder->expr()->eq('pu.user', ':participant'))
            ->setParameter(':participant', $participant->getId())
            ->orderBy($order);

        if ($count !== 0) {
            $queryBuilder
                ->setMaxResults($count)
                ->setFirstResult($count * $page);
        }

        return $queryBuilder->getQuery()->getResult();
    }

    /**
     * Finds all the projects of workflow given and ordered by value given.
     *
     * Can do pagination if $page is changed, starting from 0
     * and it can limit the search if $count is changed.
     *
     * @param \Kreta\Component\Workflow\Model\Interfaces\WorkflowInterface $workflow The workflow
     * @param string                                                       $order    The order value
     * @param string|int                                                   $count    The number of results
     * @param int                                                          $page     The number of page
     *
     * @return \Kreta\Component\Project\Model\Interfaces\ProjectInterface[]
     */
    public function findByWorkflow(WorkflowInterface $workflow, $order = 'name', $count = 10, $page = 0)
    {
        $order = 'p.' . $order;

        $queryBuilder = $this->createQueryBuilder('p');

        $queryBuilder
            ->where($queryBuilder->expr()->eq('p.workflow', ':workflow'))
            ->setParameter('workflow', $workflow)
            ->orderBy($order);

        if ($count !== 0) {
            $queryBuilder
                ->setMaxResults($count)
                ->setFirstResult($count * $page);
        }

        return $queryBuilder->getQuery()->getResult();
    }

    /**
     * {@inheritdoc}
     */
    protected function getAlias()
    {
        return 'p';
    }
}
