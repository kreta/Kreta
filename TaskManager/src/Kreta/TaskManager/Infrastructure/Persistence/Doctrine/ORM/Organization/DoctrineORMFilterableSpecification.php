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

namespace Kreta\TaskManager\Infrastructure\Persistence\Doctrine\ORM\Organization;

use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Kreta\SharedKernel\Infrastructure\Persistence\Doctrine\ORM\DoctrineORMCountSpecification;
use Kreta\SharedKernel\Infrastructure\Persistence\Doctrine\ORM\DoctrineORMQuerySpecification;
use Kreta\TaskManager\Domain\Model\Organization\Organization;
use Kreta\TaskManager\Domain\Model\User\UserId;

class DoctrineORMFilterableSpecification implements DoctrineORMQuerySpecification, DoctrineORMCountSpecification
{
    private $name;
    private $userId;
    private $offset;
    private $limit;

    public function __construct(?string $name, UserId $userId, int $offset, int $limit)
    {
        $this->name = $name;
        $this->userId = $userId;
        $this->offset = $offset;
        $this->limit = $limit;
    }

    public function buildQuery(QueryBuilder $queryBuilder) : Query
    {
        if ($this->limit > 0) {
            $queryBuilder->setMaxResults($this->limit);
        }

        if (!empty($this->name)) {
            $queryBuilder
                ->where($queryBuilder->expr()->like('o.name.name', ':name'))
                ->setParameter('name', '%' . $this->name . '%');
        }

        return $queryBuilder
            ->select('o')
            ->from(Organization::class, 'o')
            ->leftJoin('o.organizationMembers', 'om')
            ->leftJoin('o.owners', 'ow')
            ->andWhere(
                $queryBuilder->expr()->orX(
                    $queryBuilder->expr()->eq('om.userId', ':userId'),
                    $queryBuilder->expr()->eq('ow.userId', ':userId')
                )
            )
            ->setParameter('userId', $this->userId->id())
            ->setFirstResult($this->offset)
            ->getQuery();
    }

    public function buildCount(QueryBuilder $queryBuilder) : Query
    {
        if (!empty($this->name)) {
            $queryBuilder
                ->where($queryBuilder->expr()->like('o.name.name', ':name'))
                ->setParameter('name', '%' . $this->name . '%');
        }

        return $queryBuilder
            ->select($queryBuilder->expr()->count('o.id'))
            ->from(Organization::class, 'o')
            ->leftJoin('o.organizationMembers', 'om')
            ->leftJoin('o.owners', 'ow')
            ->andWhere(
                $queryBuilder->expr()->orX(
                    $queryBuilder->expr()->eq('om.userId', ':userId'),
                    $queryBuilder->expr()->eq('ow.userId', ':userId')
                )
            )
            ->setParameter('userId', $this->userId->id())
            ->getQuery();
    }
}
