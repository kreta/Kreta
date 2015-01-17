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
use Kreta\Component\Core\Repository\Traits\QueryBuilderTrait;
use Kreta\Component\VCS\Model\Interfaces\RepositoryInterface;

/**
 * Class IssueRepository.
 *
 * @package Kreta\Component\VCS\Repository
 */
class IssueRepository
{
    use QueryBuilderTrait;

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
     * @return \Kreta\Component\Issue\Model\Interfaces\IssueInterface[]
     */
    public function findRelatedIssuesByRepository(RepositoryInterface $repository, $shortName, $numericId)
    {
        $repositoryIds = [];
        foreach ($repository->getProjects() as $project) {
            $repositoryIds[] = $project->getId();
        }

        $queryBuilder = $this->repository->createQueryBuilder('i')
            ->leftJoin('i.project', 'p');
        $this->addCriteria($queryBuilder, [
                'in'          => ['i.project' => $repositoryIds],
                'p.shortName' => $shortName, 'i.numericId' => $numericId
            ]
        );

        return $queryBuilder->getQuery()->getResult();
    }
}
