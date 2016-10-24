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

    public function write(Organization $organization)
    {
        $this->organization = $organization;
    }

    public function read()
    {
        if (null === $this->organization) {
            return [];
        }

        return [
            'id'         => $this->organization->id()->id(),
            'name'       => $this->organization->name()->name(),
            'slug'       => $this->organization->slug()->slug(),
            'created_on' => $this->organization->createdOn()->format('Y-m-d'),
            'updated_on' => $this->organization->updatedOn()->format('Y-m-d'),
        ];
    }
}
