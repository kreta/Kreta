<?php

/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Kreta\TaskManager\Infrastructure\Persistence\Doctrine\ORM\Project;

use Doctrine\ORM\EntityRepository;
use Kreta\TaskManager\Domain\Model\Project\Project;
use Kreta\TaskManager\Domain\Model\Project\ProjectId;
use Kreta\TaskManager\Domain\Model\Project\ProjectRepository;

class DoctrineORMProjectRepository extends EntityRepository implements ProjectRepository
{
    public function projectOfId(ProjectId $id)
    {
        return $this->find($id->id());
    }

    public function query($specification)
    {
        return null === $specification
            ? $this->findAll()
            : $specification->buildQuery($this->getEntityManager()->createQueryBuilder())->getResult();
    }

    public function persist(Project $project)
    {
        $this->getEntityManager()->persist($project);
    }

    public function remove(Project $project)
    {
        $this->getEntityManager()->remove($project);
    }

    public function count($specification) : int
    {
        if (null === $specification) {
            $queryBuilder = $this->createQueryBuilder('p');

            return (int) $queryBuilder
                ->select($queryBuilder->expr()->count('p.id'))
                ->getQuery()
                ->getSingleScalarResult();
        }

        return (int) $specification->buildCount(
            $this->getEntityManager()->createQueryBuilder()
        )->getSingleScalarResult();
    }
}
