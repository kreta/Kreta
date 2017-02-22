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
use Kreta\SharedKernel\Domain\Model\Identity\Slug;
use Kreta\SharedKernel\Infrastructure\Persistence\Doctrine\ORM\DoctrineORMQuerySpecification;
use Kreta\TaskManager\Domain\Model\Organization\Organization;

class DoctrineORMBySlugSpecification implements DoctrineORMQuerySpecification
{
    private $slug;

    public function __construct(Slug $slug)
    {
        $this->slug = $slug;
    }

    public function buildQuery(QueryBuilder $queryBuilder) : Query
    {
        return $queryBuilder
            ->select('o')
            ->from(Organization::class, 'o')
            ->leftJoin('o.organizationMembers', 'om')
            ->leftJoin('o.owners', 'ow')
            ->where($queryBuilder->expr()->like('o.slug.slug', ':slug'))
            ->andWhere(
                $queryBuilder->expr()->orX(
                    $queryBuilder->expr()->eq('om.userId', ':userId'),
                    $queryBuilder->expr()->eq('ow.userId', ':userId')
                )
            )
            ->setParameter('slug', $this->slug)
            ->getQuery();
    }
}
