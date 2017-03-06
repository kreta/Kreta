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

use Kreta\SharedKernel\Domain\Model\Identity\Uuid;

class CreateOrganizationCommand
{
    private $creatorId;
    private $name;
    private $id;
    private $slug;

    public function __construct(
        string $creatorId,
        string $name,
        string $id = null,
        string $slug = null
    ) {
        $this->id = null === $id ? Uuid::generate() : $id;
        $this->creatorId = $creatorId;
        $this->name = $name;
        $this->slug = $slug;
    }

    public function id() : string
    {
        return $this->id;
    }

    public function name() : string
    {
        return $this->name;
    }

    public function creatorId() : string
    {
        return $this->creatorId;
    }

    public function slug()
    {
        return $this->slug;
    }
}
