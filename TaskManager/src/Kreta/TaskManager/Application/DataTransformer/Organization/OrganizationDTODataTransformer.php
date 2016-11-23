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

namespace Kreta\TaskManager\Application\DataTransformer\Organization;

use Kreta\TaskManager\Domain\Model\Organization\Organization;

class OrganizationDTODataTransformer implements OrganizationDataTransformer
{
    private $organization;
    private $memberDataTransformer;

    public function __construct(MemberDataTransformer $memberDataTransformer)
    {
        $this->memberDataTransformer = $memberDataTransformer;
    }

    public function write(Organization $organization)
    {
        $this->organization = $organization;
    }

    public function read()
    {
        if (!$this->organization instanceof Organization) {
            return [];
        }

        $owners = [];
        foreach ($this->organization->owners() as $owner) {
            $this->memberDataTransformer->write($owner);
            $owners[] = $this->memberDataTransformer->read();
        }

        $organizationMembers = [];
        foreach ($this->organization->organizationMembers() as $organizationMember) {
            $this->memberDataTransformer->write($organizationMember);
            $organizationMembers[] = $this->memberDataTransformer->read();
        }

        return [
            'id'                  => $this->organization->id()->id(),
            'name'                => $this->organization->name()->name(),
            'slug'                => $this->organization->slug()->slug(),
            'created_on'          => $this->organization->createdOn()->format('Y-m-d'),
            'updated_on'          => $this->organization->updatedOn()->format('Y-m-d'),
            'owners'              => $owners,
            'organizationMembers' => $organizationMembers,
        ];
    }
}
