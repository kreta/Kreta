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

namespace Kreta\TaskManager\Application\Command\Project;

use Kreta\SharedKernel\Domain\Model\Identity\Uuid;

class CreateProjectCommand
{
    private $id;
    private $name;
    private $slug;
    private $organizationId;
    private $reporterId;

    public function __construct(
        string $name,
        string $organizationId,
        string $reporterId,
        string $id = null,
        string $slug = null
    ) {
        $this->id = null === $id ? Uuid::generate() : $id;
        $this->name = $name;
        $this->slug = $slug;
        $this->organizationId = $organizationId;
        $this->reporterId = $reporterId;
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

    public function reporterId() : string
    {
        return $this->reporterId;
    }
}
