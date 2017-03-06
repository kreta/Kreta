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

use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Kreta\SharedKernel\Domain\Model\Identity\Slug;
use Kreta\SharedKernel\Infrastructure\Persistence\Doctrine\ORM\DoctrineORMQuerySpecification;
use Kreta\TaskManager\Domain\Model\Project\Project;

class DoctrineORMBySlugSpecification implements DoctrineORMQuerySpecification
{
    private $slug;
    private $organizationSlug;

    public function __construct(Slug $slug, Slug $organizationSlug)
    {
        $this->slug = $slug;
        $this->organizationSlug = $organizationSlug;
    }

    public function buildQuery(QueryBuilder $queryBuilder) : Query
    {
        return $queryBuilder
            ->select('p')
            ->from(Project::class, 'p')
            ->join('p.organizationId', 'o', Query\Expr\Join::WITH, 'p.organizationId = o.id')
            ->where($queryBuilder->expr()->eq('p.slug.slug', ':slug'))
            ->andWhere($queryBuilder->expr()->eq('o.slug.slug', ':organizationSlug'))
            ->setParameter('slug', $this->slug)
            ->setParameter('organizationSlug', $this->organizationSlug)
            ->getQuery();
    }
}
