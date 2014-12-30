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

use Doctrine\Common\Util\Debug;
use Doctrine\ORM\EntityRepository;
use Kreta\Component\VCS\Model\Interfaces\RepositoryInterface;

/**
 * Class RepositoryRepository
 *
 * @package Kreta\Component\VCS\Repository
 */
class RepositoryRepository extends EntityRepository
{
    public function findRelatedIssuesByRepository(RepositoryInterface $repository, $shortName)
    {
        $queryBuilder = $this->createQueryBuilder('r');
        $queryBuilder->leftJoin('r.project', 'p')
            ->leftJoin('p.issue', 'i')
            ->where('r.id = :repositoryId')
            ->andWhere('p.shortName = :shortName')
            ->andWhere('i.numberId = :numberId')
            ->setParameter('repositoryId', $repository->getId())
            ->setParameter('shortName', $shortName)
            ->setParameter('numericId', $numericId);

        Debug::dump($queryBuilder->getQuery()->getResult());
    }
}
