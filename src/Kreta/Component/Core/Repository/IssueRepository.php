<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Component\Core\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Kreta\Component\Core\Model\Interfaces\UserInterface;

/**
 * Class IssueRepository.
 *
 * @package Kreta\Component\Core\Repository
 */
class IssueRepository extends EntityRepository
{
    private $validFilters = array('status', 'priority');

    /**
     * Finds all the issues of reporter given.
     *
     * @param \Kreta\Component\Core\Model\Interfaces\UserInterface $reporter The reporter
     *
     * @return \Kreta\Component\Core\Model\Interfaces\IssueInterface[]
     */
    public function findByReporter(UserInterface $reporter)
    {
        $queryBuilder = $this->createQueryBuilder('i');

        return $queryBuilder->select('i')
            ->where($queryBuilder->expr()->eq('i.reporter', ':reporter'))
            ->setParameter(':reporter', $reporter->getId())
            ->getQuery()->getResult();
    }

    /**
     * Finds all the issues of assignee given.
     *
     * @param \Kreta\Component\Core\Model\Interfaces\UserInterface $assignee The assignee
     * @param array                                                $filters  Fields and values to be filtered
     * @param array                                                $orderBy  Fileds and strategy to order issues
     *
     * @return \Kreta\Component\Core\Model\Interfaces\IssueInterface[]
     */
    public function findByAssignee(UserInterface $assignee, $filters, $orderBy)
    {
        $queryBuilder = $this->createQueryBuilder('i');

        $queryBuilder->select('i')
            ->where($queryBuilder->expr()->eq('i.assignee', ':assignee'))
            ->setParameter(':assignee', $assignee->getId());

        $queryBuilder = $this->orderBy($orderBy, $queryBuilder);

        return $queryBuilder->getQuery()->getResult();
    }

    protected function orderBy($orderBy, QueryBuilder $queryBuilder)
    {
        foreach ($orderBy as $sort => $order) {
            if(in_array($sort, $this->validFilters)) {
                $queryBuilder->orderBy('i.'.$sort, $order);
            } else {
                throw new \Exception($sort. ' is not a valid filter');
            }
        }

        return $queryBuilder;
    }
}
