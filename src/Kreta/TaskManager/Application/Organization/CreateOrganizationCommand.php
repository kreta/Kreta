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

    public function __construct(
        string $userId,
        string $name,
        string $id = null,
        string $ownerId = null,
        string $slug = null
    ) {
        if ('' === $userId) {
            throw new InvalidArgumentException('User id cannot be null');
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

    public function name() : string
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

    public function userId() : string
    {
        return $this->userId;
    }
}
