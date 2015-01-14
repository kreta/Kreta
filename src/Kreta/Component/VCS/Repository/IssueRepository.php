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
 * Class IssueRepository.
 *
 * @package Kreta\Component\VCS\Repository
 */
class IssueRepository
{
    /**
     * The entity manager.
     *
     * @var \Doctrine\ORM\EntityManager
     */
    protected $manager;

    /**
     * The class name.
     *
     * @var string
     */
    protected $className;

    /**
     * The entity repository.
     *
     * @var \Doctrine\ORM\EntityRepository
     */
    protected $repository;

    /**
     * Constructor.
     *
     * @param \Doctrine\ORM\EntityManager $manager   The entity manager
     * @param string                      $className The class name
     */
    public function __construct(EntityManager $manager, $className)
    {
        $this->manager = $manager;
        $this->className = $className;
        $this->repository = $this->manager->getRepository($className);
    }

    /**
     * Finds related issues of repository, short name and numeric id given.
     *
     * @param \Kreta\Component\VCS\Model\Interfaces\RepositoryInterface $repository The repository
     * @param  string                                                   $shortName  The short name
     * @param  string                                                   $numericId  The numeric id
     *
     * @return array
     */
    public function findRelatedIssuesByRepository(RepositoryInterface $repository, $shortName, $numericId)
    {
        $repositoryIds = [];
        foreach ($repository->getProjects() as $project) {
            $repositoryIds[] = $project->getId();
        }

        $queryBuilder = $this->repository->createQueryBuilder('i');

        return $queryBuilder
            ->leftJoin('i.project', 'p')
            ->where($queryBuilder->expr()->in('i.project', $repositoryIds))
            ->andWhere('p.shortName = :shortName')
            ->andWhere('i.numericId = :numericId')
            ->setParameter('shortName', $shortName)
            ->setParameter('numericId', $numericId)
            ->getQuery()->getResult();
    }
}
