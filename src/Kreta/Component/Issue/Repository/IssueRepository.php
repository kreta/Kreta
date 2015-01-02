<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Component\Issue\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Finite\State\StateInterface;
use Kreta\Component\Project\Model\Interfaces\ProjectInterface;
use Kreta\Component\User\Model\Interfaces\UserInterface;
use Kreta\Component\Workflow\Model\Interfaces\WorkflowInterface;

/**
 * Class IssueRepository.
 *
 * @package Kreta\Component\Issue\Repository
 */
class IssueRepository extends EntityRepository
{
    /**
     * Array that contains the default valid filters to use in ordering.
     *
     * @var string[]
     */
    private $validFilters = ['status', 'priority', 'createdAt', 'title'];

    /**
     * Finds all the issues of project given.
     *
     * Can do pagination if $page is changed, starting from 0 and it can
     * limit the search if $count is changed. Furthermore, it can filter
     * by issue title, assignee, reporter, watcher, priority, status and type.
     *
     * @param \Kreta\Component\Project\Model\Interfaces\ProjectInterface $project The project
     * @param array                                                      $orderBy Array that contains the orders
     * @param int                                                        $count   The number of results
     * @param int                                                        $page    The number of page
     * @param array                                                      $filters Array that contains all the filter
     *                                                                            that support this method
     *
     * @return \Kreta\Component\Issue\Model\Interfaces\IssueInterface[]
     */
    public function findByProject(
        ProjectInterface $project,
        array $orderBy = ['createdAt' => 'ASC'],
        $count = 10,
        $page = 0,
        array $filters = []
    )
    {
        $whereSql = ' 1=1 ';
        $parameters = [];
        foreach ($filters as $key => $filter) {
            if ($filter !== '') {
                if (strpos($key, '.') !== false) {
                    list($classPrefix, $key) = explode('.', $key);
                    $whereSql .= 'AND ' . $classPrefix . '.' . $key . ' LIKE :' . $classPrefix . $key . ' ';
                    $parameters[$classPrefix . $key] = '%' . $filter . '%';
                } else {
                    $whereSql .= 'AND i.' . $key . ' LIKE :' . $key . ' ';
                    $parameters[$key] = '%' . $filter . '%';
                }
            }
        }
        $parameters['project'] = $project->getId();

        $queryBuilder = $this->_em->createQueryBuilder();
        $queryBuilder->select(['i', 'a', 'c', 'l', 'p', 'r', 'rep', 's', 'w'])
            ->from($this->_entityName, 'i')
            ->leftJoin('i.assignee', 'a')
            ->leftJoin('i.comments', 'c')
            ->leftJoin('i.labels', 'l')
            ->leftJoin('i.project', 'p')
            ->leftJoin('i.resolution', 'r')
            ->leftJoin('i.reporter', 'rep')
            ->leftJoin('i.status', 's')
            ->leftJoin('i.watchers', 'w')
            ->where($queryBuilder->expr()->eq('i.project', ':project'))
            ->andWhere($whereSql)
            ->setParameters($parameters);
        if ($count !== 0) {
            $queryBuilder
                ->setMaxResults($count)
                ->setFirstResult($count * $page);
        }
        $queryBuilder = $this->orderBy($queryBuilder, $orderBy);

        return $queryBuilder->getQuery()->getResult();
    }

    /**
     * Finds all the issues of reporter given.
     *
     * @param \Kreta\Component\User\Model\Interfaces\UserInterface $reporter The reporter
     *
     * @return \Kreta\Component\Issue\Model\Interfaces\IssueInterface[]
     */
    public function findByReporter(UserInterface $reporter)
    {
        $queryBuilder = $this->createQueryBuilder('i');

        return $queryBuilder
            ->where($queryBuilder->expr()->eq('i.reporter', ':reporter'))
            ->setParameter(':reporter', $reporter->getId())
            ->getQuery()->getResult();
    }

    /**
     * Finds all the issues of assignee given.
     *
     * @param \Kreta\Component\User\Model\Interfaces\UserInterface $assignee The assignee
     * @param array                                                $orderBy  Fields and strategy to order issues
     * @param bool                                                 $onlyOpen Shows only open issues
     *
     * @return \Kreta\Component\Issue\Model\Interfaces\IssueInterface[]
     */
    public function findByAssignee(UserInterface $assignee, array $orderBy, $onlyOpen = false)
    {
        $queryBuilder = $this->createQueryBuilder('i');

        $queryBuilder
            ->leftJoin('i.status', 'st')
            ->where($queryBuilder->expr()->eq('i.assignee', ':assignee'))
            ->setParameter(':assignee', $assignee->getId());
        if ($onlyOpen) {
            $queryBuilder->andWhere($queryBuilder->expr()->neq('st.type', ':state'))
                ->setParameter(':state', StateInterface::TYPE_FINAL);
        }

        $queryBuilder = $this->orderBy($queryBuilder, $orderBy);

        return $queryBuilder->getQuery()->getResult();
    }

    /**
     * Finds one issue by its short code.
     *
     * @param string $projectShortName The 4 character project short name of the issue to find
     * @param string $issueNumber      Numeric number of the issue to find
     *
     * @return \Kreta\Component\Issue\Model\Interfaces\IssueInterface
     */
    public function findOneByShortCode($projectShortName, $issueNumber)
    {
        $queryBuilder = $this->createQueryBuilder('i');

        $queryBuilder
            ->join('i.project', 'p')
            ->where($queryBuilder->expr()->eq('i.numericId', ':issueNumber'))
            ->andWhere($queryBuilder->expr()->eq('p.shortName', ':projectShortName'))
            ->setParameter('issueNumber', $issueNumber)
            ->setParameter('projectShortName', $projectShortName);

        return $queryBuilder->getQuery()->getOneOrNullResult();
    }

    /**
     * Finds all the issues of workflow given.
     *
     * @param \Kreta\Component\Workflow\Model\Interfaces\WorkflowInterface $workflow The workflow
     *
     * @return \Kreta\Component\Issue\Model\Interfaces\IssueInterface[]
     */
    public function findByWorkflow(WorkflowInterface $workflow)
    {
        $queryBuilder = $this->createQueryBuilder('i');

        return $queryBuilder
            ->innerJoin('i.project', 'pr')
            ->where($queryBuilder->expr()->eq('pr.workflow', ':workflow'))
            ->setParameter('workflow', $workflow)
            ->getQuery()->getResult();
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
    protected function orderBy(QueryBuilder $queryBuilder, array $orderBy = [])
    {
        foreach ($orderBy as $sort => $order) {
            if (in_array($sort, $this->validFilters)) {
                $queryBuilder->orderBy('i.' . $sort, $order);
            } else {
                throw new \Exception($sort . ' is not a valid filter');
            }
        }

        return $queryBuilder;
    }
}
