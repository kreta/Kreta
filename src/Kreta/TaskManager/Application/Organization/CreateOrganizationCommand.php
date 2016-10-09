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

use Kreta\SharedKernel\Domain\Model\InvalidArgumentException;

class CreateOrganizationCommand
{
    private $id;
    private $ownerId;
    private $userId;
    private $name;
    private $slug;

    public function __construct(string $ownerId, string $userId, string $name, string $id = null, string $slug = null)
    {
        if ('' === $ownerId) {
            throw new InvalidArgumentException('Owner id cannot be null');
        }
        if ('' === $userId) {
            throw new InvalidArgumentException('User id cannot be null');
        }
        if ('' === $name) {
            throw new InvalidArgumentException('Organization name cannot be null');
        }
        $this->id = $id;
        $this->ownerId = $ownerId;
        $this->userId = $userId;
        $this->name = $name;
        $this->slug = $slug;
    }

    public function id()
    {
        return $this->id;
    }

    public function name()
    {
        return $this->name;
    }

    public function ownerId()
    {
        return $this->ownerId;
    }

    public function slug()
    {
        return $this->slug;
    }

    public function userId()
    {
        return $this->userId;
    }
}
