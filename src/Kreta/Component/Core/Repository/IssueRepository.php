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
use Kreta\Component\Core\Model\Interfaces\UserInterface;

/**
 * Class IssueRepository.
 *
 * @package Kreta\CoreBundle\Rpository
 */
class IssueRepository extends EntityRepository
{
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
     *
     * @return \Kreta\Component\Core\Model\Interfaces\IssueInterface[]
     */
    public function findByAssignee(UserInterface $assignee)
    {
        $queryBuilder = $this->createQueryBuilder('i');

        return $queryBuilder->select('i')
            ->where($queryBuilder->expr()->eq('i.assignee', ':assignee'))
            ->setParameter(':assignee', $assignee->getId())
            ->getQuery()->getResult();
    }
}
