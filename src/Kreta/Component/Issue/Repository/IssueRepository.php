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
     * @return \Kreta\Component\Issue\Model\Interfaces\IssueInterface
     */
    public function findOneByShortCode($projectShortName, $issueNumber)
    {
        return $this->findOneBy(['numericId' => $issueNumber, 'p.shortName' => $projectShortName]);
    }

    /**
     * {@inheritdoc}
     */
    protected function getQueryBuilder()
    {
        return parent::getQueryBuilder()
            ->addSelect(['a', 'l', 'p', 'r', 'rep', 's', 'w'])
            ->leftJoin('i.assignee', 'a')
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
