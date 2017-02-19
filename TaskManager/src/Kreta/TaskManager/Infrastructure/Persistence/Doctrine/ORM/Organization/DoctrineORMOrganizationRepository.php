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

use Doctrine\ORM\EntityRepository;
use Kreta\SharedKernel\Domain\Model\Identity\Slug;
use Kreta\TaskManager\Domain\Model\Organization\Organization;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationId;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationRepository;

class DoctrineORMOrganizationRepository extends EntityRepository implements OrganizationRepository
{
    public function organizationOfId(OrganizationId $id)
    {
        return $this->find($id->id());
    }

    public function organizationOfSlug(Slug $slug)
    {
        return $this->findOneBy(['slug' => $slug->slug()]);
    }

    public function query($specification)
    {
        return null === $specification
            ? $this->findAll()
            : $specification->buildQuery($this->getEntityManager()->createQueryBuilder())->getResult();
    }

    public function persist(Organization $organization)
    {
        $this->getEntityManager()->persist($organization);
    }

    public function remove(Organization $organization)
    {
        $this->getEntityManager()->remove($organization);
    }

    public function count($specification) : int
    {
        if (null === $specification) {
            $queryBuilder = $this->createQueryBuilder('o');

            return (int) $queryBuilder
                ->select($queryBuilder->expr()->count('o.id'))
                ->getQuery()
                ->getSingleScalarResult();
        }

        return (int) $specification->buildCount(
            $this->getEntityManager()->createQueryBuilder()
        )->getSingleScalarResult();
    }
}
