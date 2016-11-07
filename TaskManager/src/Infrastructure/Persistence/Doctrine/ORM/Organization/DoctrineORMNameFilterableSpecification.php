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

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query;
use Kreta\SharedKernel\Infrastructure\Persistence\Doctrine\ORM\DoctrineORMCountSpecification;
use Kreta\SharedKernel\Infrastructure\Persistence\Doctrine\ORM\DoctrineORMQuerySpecification;
use Kreta\TaskManager\Domain\Model\Organization\Organization;

class DoctrineORMNameFilterableSpecification implements DoctrineORMQuerySpecification, DoctrineORMCountSpecification
{
    protected $name;
    protected $offset;
    protected $limit;

    public function __construct($name, int $offset, int $limit)
    {
        $this->name = $name;
        $this->offset = $offset;
        $this->limit = $limit;
    }

    public function buildQuery(EntityManagerInterface $manager) : Query
    {
        $queryBuilder = $manager->createQueryBuilder();

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
            ->setFirstResult($this->offset)
            ->getQuery();
    }

    public function buildCount(EntityManagerInterface $manager) : Query
    {
        $queryBuilder = $manager->createQueryBuilder();

        if (!empty($this->name)) {
            $queryBuilder
                ->where($queryBuilder->expr()->like('o.name.name', ':name'))
                ->setParameter('name', '%' . $this->name . '%');
        }

        return $queryBuilder
            ->select($queryBuilder->expr()->count('o.id'))
            ->from(Organization::class, 'o')
            ->getQuery();
    }
}
