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

namespace Kreta\TaskManager\Application\Project;

use Kreta\SharedKernel\Domain\Model\Identity\Slug;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationId;

class CreateProjectCommand
{
    private $id;

    private $name;

    private $slug;

    private $organizationId;

    private $creatorId;

    public function __construct(
        string $id,
        string $name,
        string $organizationId,
        string $creatorId,
        string $slug = null
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->slug = $slug;
        $this->organizationId = $organizationId;
        $this->creatorId = $creatorId;
    }

    public function id() : string
    {
        return $this->id;
    }

    public function name() : string
    {
        return $this->name;
    }

    public function slug()
    {
        return $this->slug;
    }

    public function organizationId() : string
    {
        return $this->organizationId;
    }

    public function creatorId() : string
    {
        return $this->creatorId;
    }
}
