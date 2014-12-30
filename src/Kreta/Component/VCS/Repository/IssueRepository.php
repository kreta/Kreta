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

use Doctrine\ORM\EntityManager;
use Kreta\Component\VCS\Model\Interfaces\RepositoryInterface;

/**
 * Class IssueRepository
 *
 * @package Kreta\Component\VCS\Repository
 */
class IssueRepository
{
    /** @var \Doctrine\ORM\EntityManager */
    protected $manager;

    /** @var string */
    protected $className;

    /** @var \Doctrine\ORM\EntityRepository */
    protected $repository;

    public function __construct(EntityManager $manager, $className)
    {
        $this->manager = $manager;
        $this->className = $className;
        $this->repository = $this->manager->getRepository($className);
    }

    public function findRelatedIssuesByRepository(RepositoryInterface $repository, $shortName, $numericId)
    {
        $repositoryIds = [];
        foreach($repository->getProjects() as $project) {
            $repositoryIds[] = $project->getId();
        }

        $queryBuilder = $this->repository->createQueryBuilder('i');
        $queryBuilder->leftJoin('i.project', 'p')
            ->where($queryBuilder->expr()->in('i.project', $repositoryIds))
            ->andWhere('p.shortName = :shortName')
            ->andWhere('i.numericId = :numericId')
            ->setParameter('shortName', $shortName)
            ->setParameter('numericId', $numericId);
        return $queryBuilder->getQuery()->getResult();
    }
} 
