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

namespace Kreta\TaskManager\Infrastructure\Persistence\Doctrine\ORM\Project\Task;

use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Kreta\SharedKernel\Infrastructure\Persistence\Doctrine\ORM\DoctrineORMCountSpecification;
use Kreta\SharedKernel\Infrastructure\Persistence\Doctrine\ORM\DoctrineORMQuerySpecification;
use Kreta\TaskManager\Domain\Model\Project\Task\Task;
use Kreta\TaskManager\Domain\Model\Project\Task\TaskPriority;
use Kreta\TaskManager\Domain\Model\Project\Task\TaskProgress;

class DoctrineORMFilterableSpecification implements DoctrineORMQuerySpecification, DoctrineORMCountSpecification
{
    private $projectIds;
    private $title;
    private $priority;
    private $progress;
    private $offset;
    private $limit;

    public function __construct(
        array $projectIds,
        $title,
        ? TaskPriority $priority,
        ? TaskProgress $progress,
        int $offset,
        int $limit
    ) {
        $this->projectIds = $projectIds;
        $this->title = $title;
        $this->offset = $offset;
        $this->limit = $limit;
        $this->priority = $priority;
        $this->progress = $progress;
    }

    public function buildQuery(QueryBuilder $queryBuilder) : Query
    {
        if ($this->limit > 0) {
            $queryBuilder->setMaxResults($this->limit);
        }
        $queryBuilder = $this->addWhere($queryBuilder);

        return $queryBuilder
            ->select('t')
            ->from(Task::class, 't')
            ->andWhere($queryBuilder->expr()->in('t.projectId', ':projectIds'))
            ->setParameter('projectIds', $this->projectIds)
            ->setFirstResult($this->offset)
            ->getQuery();
    }

    public function buildCount(QueryBuilder $queryBuilder) : Query
    {
        $queryBuilder = $this->addWhere($queryBuilder);

        return $queryBuilder
            ->select($queryBuilder->expr()->count('t.id'))
            ->from(Task::class, 't')
            ->andWhere($queryBuilder->expr()->in('t.projectId', ':projectIds'))
            ->setParameter('projectIds', $this->projectIds)
            ->getQuery();
    }

    private function addWhere(QueryBuilder $queryBuilder) : QueryBuilder
    {
        if (!empty($this->title)) {
            $queryBuilder
                ->where($queryBuilder->expr()->like('t.title.title', ':title'))
                ->setParameter('title', '%' . $this->title . '%');
        }
        if (null === $this->priority) {
            $queryBuilder
                ->andWhere($queryBuilder->expr()->like('t.priority.priority', ':priority'))
                ->setParameter('priority', '%' . $this->priority->priority() . '%');
        }
        if (null === $this->progress) {
            $queryBuilder
                ->andWhere($queryBuilder->expr()->like('t.progress.progress', ':progress'))
                ->setParameter('progress', '%' . $this->progress->progress() . '%');
        }

        return $queryBuilder;
    }
}
