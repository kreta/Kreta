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
use Kreta\Component\User\Model\Interfaces\UserInterface;

/**
 * Class IssueRepository.
 *
 * @package Kreta\Component\Issue\Repository
 */
class IssueRepository extends EntityRepository
{
    /**
     * Finds all the issues of assignee given.
     *
     * @param \Kreta\Component\User\Model\Interfaces\UserInterface $assignee The assignee
     * @param array                                                $orderBy  Fields and strategy to order issues
     * @param boolean                                              $onlyOpen Shows only open issues
     *
     * @return \Kreta\Component\Issue\Model\Interfaces\IssueInterface[]
     */
    public function findByAssignee(UserInterface $assignee, array $orderBy, $onlyOpen = false)
    {
        if ($onlyOpen) {
            return $this->findBy(
                ['assignee' => $assignee, 'neq' => ['s.type' => StateInterface::TYPE_FINAL]], $orderBy
            );
        }

        return $this->findBy(['assignee' => $assignee], $orderBy);
    }

    /**
     * Finds one issue by its short code.
     *
     * @param string $projectShortName The 4 character project short name of the issue to find
     * @param string $issueNumber      Numeric number of the issue to find
     *
     * @return \Kreta\Component\Issue\Model\Interfaces\IssueInterface|null
     */
    public function findOneByShortCode($projectShortName, $issueNumber)
    {
        return $this->findOneBy(['numericId' => $issueNumber, 'p.shortName' => $projectShortName]);
    }

    /**
     * Finds all the issues where user given is participant.
     * Can do ordering, limit and offset.
     *
     * @param \Kreta\Component\User\Model\Interfaces\UserInterface $user    The user
     * @param array                                                $filters Array which contains the available filters
     * @param string[]                                             $sorting Array which contains the sorting as key/val
     * @param int                                                  $limit   The limit
     * @param int                                                  $offset  The offset
     *
     * @return \Kreta\Component\Issue\Model\Interfaces\IssueInterface[]
     */
    public function findByParticipant(
        UserInterface $user,
        array $filters = [],
        array $sorting = [],
        $limit = null,
        $offset = null
    )
    {
        $queryBuilder = $this->getQueryBuilder()
            ->addSelect('par')
            ->join('p.participants', 'par');

        $this->addCriteria($queryBuilder, ['par.user' => $user, 'like' => $filters]);
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
     * {@inheritdoc}
     */
    protected function getQueryBuilder()
    {
        return parent::getQueryBuilder()
            ->addSelect(['a', 't', 'p', 'r', 'rep', 's', 'w'])
            ->leftJoin('i.assignee', 'a')
            ->leftJoin('i.type', 't')
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
