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

class RemoveOwnerToOrganizationCommand
{
    private $userId;
    private $organizationId;
    private $removerId;

    public function __construct(string $userId, string $organizationId, string $removerId)
    {
        $this->userId = $userId;
        $this->organizationId = $organizationId;
        $this->removerId = $removerId;
    }

    public function userId() : string
    {
        return $this->userId;
    }

    public function organizationId(): string
    {
        return $this->organizationId;
    }

    public function removerId() : string
    {
        return $this->removerId;
    }
}
