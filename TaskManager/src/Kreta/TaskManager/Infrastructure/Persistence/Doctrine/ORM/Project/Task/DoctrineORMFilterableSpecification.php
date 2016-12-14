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
use Kreta\TaskManager\Domain\Model\Organization\OrganizationMemberId;
use Kreta\TaskManager\Domain\Model\Project\Task\Task;
use Kreta\TaskManager\Domain\Model\Project\Task\TaskId;
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
    private $parentId;
    private $assigneeId;
    private $creatorId;

    public function __construct(
        array $projectIds,
        $title,
        ? TaskId $parentId,
        ? TaskPriority $priority,
        ? TaskProgress $progress,
        ? OrganizationMemberId $assigneeId,
        ? OrganizationMemberId $creatorId,
        int $offset,
        int $limit
    ) {
        $this->projectIds = $projectIds;
        $this->title = $title;
        $this->offset = $offset;
        $this->limit = $limit;
        $this->priority = $priority;
        $this->progress = $progress;
        $this->parentId = $parentId;
        $this->assigneeId = $assigneeId;
        $this->creatorId = $creatorId;
    }

    public function buildQuery(QueryBuilder $queryBuilder) : Query
    {
        if ($this->limit > 0) {
            $queryBuilder->setMaxResults($this->limit);
        }
        $queryBuilder = $this->setWhereClauses($queryBuilder);

        return $queryBuilder
            ->select('t')
            ->from(Task::class, 't')
            ->setFirstResult($this->offset)
            ->getQuery();
    }

    public function buildCount(QueryBuilder $queryBuilder) : Query
    {
        $queryBuilder = $this->setWhereClauses($queryBuilder);

        return $queryBuilder
            ->select($queryBuilder->expr()->count('t.id'))
            ->from(Task::class, 't')
            ->getQuery();
    }

    private function setWhereClauses(QueryBuilder $queryBuilder) : QueryBuilder
    {
        $queryBuilder
            ->andWhere($queryBuilder->expr()->in('t.projectId', ':projectIds'))
            ->setParameter('projectIds', $this->projectIds);

        if (!empty($this->title)) {
            $queryBuilder
                ->where($queryBuilder->expr()->like('t.title.title', ':title'))
                ->setParameter('title', '%' . $this->title . '%');
        }
        if (null !== $this->parentId) {
            $queryBuilder
                ->andWhere($queryBuilder->expr()->eq('t.parentId', ':parentId'))
                ->setParameter('parentId', $this->parentId->id());
        }
        if (null !== $this->priority) {
            $queryBuilder
                ->andWhere($queryBuilder->expr()->eq('t.priority.priority', ':priority'))
                ->setParameter('priority', $this->priority->priority());
        }
        if (null !== $this->progress) {
            $queryBuilder
                ->andWhere($queryBuilder->expr()->eq('t.progress.progress', ':progress'))
                ->setParameter('progress', $this->progress->progress());
        }
        if (null !== $this->assigneeId) {
            $queryBuilder
                ->andWhere($queryBuilder->expr()->eq('t.assigneeId', ':assigneeId'))
                ->setParameter('assigneeId', $this->assigneeId->id());
        }
        if (null !== $this->creatorId) {
            $queryBuilder
                ->andWhere($queryBuilder->expr()->eq('t.creatorId', ':creatorId'))
                ->setParameter('creatorId', $this->creatorId->id());
        }

        return $queryBuilder;
    }
}
