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

namespace Kreta\TaskManager\Application\Command\Organization;

class AddOwnerToOrganizationCommand
{
    private $adderId;
    private $userId;
    private $organizationId;

    public function __construct(string $adderId, string $userId, string $organizationId)
    {
        $this->adderId = $adderId;
        $this->userId = $userId;
        $this->organizationId = $organizationId;
    }

    public function adderId() : string
    {
        return $this->adderId;
    }

    public function userId() : string
    {
        return $this->userId;
    }

    public function organizationId() : string
    {
        return $this->organizationId;
    }
}
