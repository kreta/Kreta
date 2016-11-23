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

namespace Kreta\TaskManager\Domain\Model\Organization;

interface OrganizationRepository
{
    public function organizationOfId(OrganizationId $id);

    public function query($specification);

    public function persist(Organization $organization);

    public function remove(Organization $organization);

    public function count($specification) : int;
}
