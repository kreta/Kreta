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
use Finite\State\StateInterface;
use Kreta\Component\Core\Model\Interfaces\UserInterface;

/**
 * Class IssueRepository.
 *
 * @package Kreta\Component\Core\Repository
 */
class IssueRepository extends EntityRepository
{
    /**
     * Array that contains the default valid filters.
     *
     * @var string[]
     */
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
     * @param \Kreta\Component\Core\Model\Interfaces\UserInterface $assignee  The assignee
     * @param array                                                $orderBy   Fields and strategy to order issues
     * @param bool                                                 $onlyOpen  Shows only open issues
     *
     * @return \Kreta\Component\Core\Model\Interfaces\IssueInterface[]
     */
    public function findByAssignee(UserInterface $assignee, $orderBy, $onlyOpen = false)
    {
        $queryBuilder = $this->createQueryBuilder('i');

        $queryBuilder->select('i')
            ->leftJoin('i.status','st')
            ->where($queryBuilder->expr()->eq('i.assignee', ':assignee'))
            ->setParameter(':assignee', $assignee->getId());
        if($onlyOpen) {
            $queryBuilder->andWhere($queryBuilder->expr()->neq('st.type', ':state'))
                         ->setParameter(':state', StateInterface::TYPE_FINAL);
        }

        $queryBuilder = $this->orderBy($queryBuilder, $orderBy);

        return $queryBuilder->getQuery()->getResult();
    }

    /**
     * Manages the order by statement into queries.
     *
     * @param \Doctrine\ORM\QueryBuilder $queryBuilder The query builder
     * @param string[]                   $orderBy      Array that contains the orders
     *
     * @return \Doctrine\ORM\QueryBuilder
     * @throws \Exception when it is not a valid filter
     */
    protected function orderBy(QueryBuilder $queryBuilder, array $orderBy = array())
    {
        foreach ($orderBy as $sort => $order) {
            if (in_array($sort, $this->validFilters) === true) {
                $queryBuilder->orderBy('i.' . $sort, $order);
            } else {
                throw new \Exception($sort . ' is not a valid filter');
            }
        }

        return $queryBuilder;
    }
}
