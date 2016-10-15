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

namespace Kreta\TaskManager\Application\Organization;

class RemoveMemberToOrganizationCommand
{
    private $removerId;
    private $userId;
    private $organizationId;

    public function __construct(string $removerId, string $userId, string $organizationId)
    {
        $this->removerId = $removerId;
        $this->userId = $userId;
        $this->organizationId = $organizationId;
    }

    public function removerId() : string
    {
        return $this->removerId;
    }

    public function userId() : string
    {
        return $this->userId;
    }

    public function organizationId(): string
    {
        return $this->organizationId;
    }
}
