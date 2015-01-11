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

use Finite\State\StateInterface;
use Kreta\Component\Core\Repository\EntityRepository;
use Kreta\Component\Project\Model\Interfaces\ProjectInterface;
use Kreta\Component\User\Model\Interfaces\UserInterface;
use Kreta\Component\Workflow\Model\Interfaces\StatusInterface;
use Kreta\Component\Workflow\Model\Interfaces\StatusTransitionInterface;
use Kreta\Component\Workflow\Model\Interfaces\WorkflowInterface;

/**
 * Class IssueRepository.
 *
 * @package Kreta\Component\Issue\Repository
 */
class IssueRepository extends EntityRepository
{
    /**
     * Finds all the issues of project given.
     * Can do ordering, limit and offset.
     *
     * Furthermore, it can filter by issue title, assignee, reporter, watcher, priority, status and type.
     *
     * @param \Kreta\Component\Project\Model\Interfaces\ProjectInterface $project The project
     * @param array                                                      $filters Array which contains all the filters
     *                                                                            for search the results in the query
     * @param string[]                                                   $sorting Array which contains the sorting
     * @param int                                                        $limit   The limit
     * @param int                                                        $offset  The offset
     *
     * @return \Kreta\Component\Issue\Model\Interfaces\IssueInterface[]
     */
    public function findByProject(
        ProjectInterface $project,
        array $filters = [],
        array $sorting = [],
        $limit = null,
        $offset = null
    )
    {
        $queryBuilder = $this->getQueryBuilder();
        $this->addCriteria($queryBuilder, ['project' => $project]);
        $this->addCriteria($queryBuilder, $filters, false);
        $this->orderBy($queryBuilder, $sorting);
        if ($limit) {
            $queryBuilder->setMaxResults($limit);
        }
        if ($offset) {
            $queryBuilder->setFirstResult($offset);
        }

        return $queryBuilder->getQuery()->getResult();
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
        $queryBuilder = $this->getQueryBuilder();
        $this->addCriteria($queryBuilder, ['assignee' => $assignee]);
        if ($onlyOpen) {
            $queryBuilder->andWhere($queryBuilder->expr()->neq('s.type', ':statusType'))
                ->setParameter('statusType', StateInterface::TYPE_FINAL);
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
        $queryBuilder = $this->getQueryBuilder();
        $this->addCriteria($queryBuilder, ['numericId' => $issueNumber, 'p.shortName' => $projectShortName]);

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
        $queryBuilder = $this->getQueryBuilder();
        $this->addCriteria($queryBuilder, ['p.workflow' => $workflow]);

        return $queryBuilder->getQuery()->getResult();
    }

    /**
     * Checks if the status given is in use by any issue of workflow given.
     *
     * @param \Kreta\Component\Workflow\Model\Interfaces\StatusInterface $status The status
     *
     * @return boolean
     */
    public function isStatusInUse(StatusInterface $status)
    {
        $issues = $this->findByWorkflow($status->getWorkflow());
        if ($status instanceof StatusInterface) {
            foreach ($issues as $issue) {
                if ($issue->getStatus()->getId() === $status->getId()) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Checks if the transition given is in use by any issue of workflow given.
     *
     * @param \Kreta\Component\Workflow\Model\Interfaces\StatusTransitionInterface $transition The status transition
     *
     * @return boolean
     */
    public function isTransitionInUse(StatusTransitionInterface $transition)
    {
        $issues = $this->findByWorkflow($transition->getWorkflow());
        if ($transition instanceof StatusTransitionInterface) {
            foreach ($issues as $issue) {
                foreach ($issue->getStatus()->getTransitions() as $retrieveTransition) {
                    if ($retrieveTransition->getId() === $transition->getId()) {
                        return true;
                    }
                }
            }
        }

        return false;
    }

    /**
     * {@inheritdoc}
     */
    protected function getQueryBuilder()
    {
        return parent::getQueryBuilder()
            ->addSelect(['a', 'c', 'l', 'p', 'r', 'rep', 's', 'w'])
            ->leftJoin('i.assignee', 'a')
            ->leftJoin('i.comments', 'c')
            ->leftJoin('i.labels', 'l')
            ->leftJoin('i.project', 'p')
            ->leftJoin('i.resolution', 'r')
            ->leftJoin('i.reporter', 'rep')
            ->leftJoin('i.status', 's')
            ->leftJoin('i.watchers', 'w');
    }

    /**
     * {@inheritdoc}
     */
    protected function getAlias()
    {
        return 'i';
    }
}
