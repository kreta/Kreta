<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Component\VCS\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Class RepositoryRepository.
 *
 * @package Kreta\Component\VCS\Repository
 */
class RepositoryRepository extends EntityRepository
{
    /**
     * Finds all the repositories of issue id given.
     *
     * @param string $issueId The issue id
     *
     * @return \Kreta\Component\VCS\Model\Interfaces\RepositoryInterface[]
     */
    public function findByIssue($issueId)
    {
        $queryBuilder = $this->createQueryBuilder('r');
        $queryBuilder->leftJoin('r.projects', 'p')
            ->leftJoin('p.issues', 'i')
            ->where('i.id = :issueId')
            ->setParameter('issueId', $issueId);

        return $queryBuilder->getQuery()->getResult();
    }
}
