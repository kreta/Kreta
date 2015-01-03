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
use Doctrine\ORM\NoResultException;
use Kreta\Component\VCS\Model\Branch;
use Kreta\Component\VCS\Model\Interfaces\RepositoryInterface;

/**
 * Class BranchRepository
 *
 * @package Kreta\Component\VCS\Repository
 */
class BranchRepository extends EntityRepository
{
    /**
     * Tries to find a branch by repository and branch name and throws exception if is not able to do so.
     *
     * @param RepositoryInterface $repository
     * @param string              $branchName
     *
     * @return \Kreta\Component\VCS\Model\Interfaces\BranchInterface
     */
    public function findOrCreateBranch(RepositoryInterface $repository, $branchName)
    {
        $queryBuilder = $this->createQueryBuilder('b');

        $queryBuilder->where('b.name = :branchName')
            ->andWhere('b.repository = :repositoryId')
            ->setParameter('branchName', $branchName)
            ->setParameter('repositoryId', $repository->getId());

        try {
            return $queryBuilder->getQuery()->getSingleResult();
        } catch (NoResultException $e) {
            $branch = new Branch();
            $branch->setName($branchName)
                ->setRepository($repository);

            $this->_em->persist($branch);
            $this->_em->flush();

            return $branch;
        }
    }
} 
