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

namespace Kreta\TaskManager\Domain\Model\Project;

use Kreta\SharedKernel\Domain\Model\AggregateRoot;
use Kreta\SharedKernel\Domain\Model\Identity\Slug;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationId;

class Project extends AggregateRoot
{
    private $id;
    private $name;
    private $slug;
    private $createdOn;
    private $updatedOn;
    private $organizationId;

    public function __construct(ProjectId $id, ProjectName $name, Slug $slug, OrganizationId $organizationId)
    {
        $this->id = $id;
        $this->name = $name;
        $this->slug = $slug;
        $this->createdOn = new \DateTimeImmutable();
        $this->updatedOn = new \DateTimeImmutable();
        $this->organizationId = $organizationId;

        $this->publish(
            new ProjectCreated($id)
        );
    }

    public function id() : ProjectId
    {
        return $this->id;
    }

    public function name() : ProjectName
    {
        return $this->name;
    }

    public function slug() : Slug
    {
        return $this->slug;
    }

    public function createdOn() : \DateTimeInterface
    {
        return $this->createdOn;
    }

    public function updatedOn() : \DateTimeInterface
    {
        return $this->updatedOn;
    }

    public function edit(ProjectName $name, Slug $slug)
    {
        $this->name = $name;
        $this->slug = $slug;
        $this->updatedOn = new \DateTimeImmutable();

        $this->publish(
            new ProjectEdited($this->id)
        );
    }

    public function __toString() : string
    {
        return (string) $this->id->id();
    }

    public function organizationId() : OrganizationId
    {
        return $this->organizationId;
    }
}
