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

namespace Kreta\TaskManager\Infrastructure\Persistence\ORM\Organization;

use Doctrine\ORM\EntityRepository;
use Kreta\TaskManager\Domain\Model\Organization\Organization;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationId;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationRepository;

class DoctrineORMOrganizationRepository extends EntityRepository implements OrganizationRepository
{
    public function organizationOfId(OrganizationId $id)
    {
        return $this->find($id->id());
    }

    public function persist(Organization $organization)
    {
        $this->getEntityManager()->persist($organization);
    }

    public function remove(Organization $organization)
    {
        $this->getEntityManager()->remove($organization);
    }
}
