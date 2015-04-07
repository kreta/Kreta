<?php

/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace Kreta\Component\VCS\Repository;

use Doctrine\ORM\NoResultException;
use Kreta\Component\Core\Repository\EntityRepository;
use Kreta\Component\VCS\Model\Branch;
use Kreta\Component\VCS\Model\Interfaces\RepositoryInterface;

/**
 * Class BranchRepository.
 *
 * @package Kreta\Component\VCS\Repository
 */
class BranchRepository extends EntityRepository
{
    /**
     * Tries to find a branch by repository and branch name and throws exception if is not able to do so.
     *
     * @param \Kreta\Component\VCS\Model\Interfaces\RepositoryInterface $repository The repository
     * @param string                                                    $branchName The branch name
     *
     * @return \Kreta\Component\VCS\Model\Interfaces\BranchInterface
     */
    public function findOrCreateBranch(RepositoryInterface $repository, $branchName)
    {
        try {
            return $this->findOneBy(['name' => $branchName, 'repository' => $repository], false);
        } catch (NoResultException $e) {
            $branch = new Branch();
            $branch
                ->setName($branchName)
                ->setRepository($repository);

            $this->persist($branch);

            return $branch;
        }
    }

    /**
     * Finds all the branches of issue id given.
     *
     * @param string $issueId The issue id
     *
     * @return \Kreta\Component\VCS\Model\Interfaces\BranchInterface[]
     */
    public function findByIssue($issueId)
    {
        return $this->findBy(['ir.id' => $issueId]);
    }

    /**
     * {@inheritdoc}
     */
    protected function getQueryBuilder()
    {
        return parent::getQueryBuilder()
            ->addSelect(['ir', 'r'])
            ->innerJoin('b.issuesRelated', 'ir')
            ->innerJoin('b.repository', 'r');
    }

    /**
     * {@inheritdoc}
     */
    protected function getAlias()
    {
        return 'b';
    }
}
