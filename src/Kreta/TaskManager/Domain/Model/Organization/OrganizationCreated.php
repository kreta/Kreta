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

use Kreta\SharedKernel\Domain\Model\DomainEvent;
use Kreta\SharedKernel\Domain\Model\Identity\Slug;

class OrganizationCreated implements DomainEvent
{
    private $organizationId;
    private $organizationName;
    private $organizationSlug;
    private $occurredOn;

    public function __construct(OrganizationId $id, OrganizationName $name, Slug $slug)
    {
        $this->organizationId = $id;
        $this->organizationName = $name;
        $this->organizationSlug = $slug;
        $this->occurredOn = new \DateTimeImmutable();
    }

    public function organizationId() : OrganizationId
    {
        return $this->organizationId;
    }

    public function organizationName() : OrganizationName
    {
        return $this->organizationName;
    }

    public function organizationSlug() : Slug
    {
        return $this->organizationSlug;
    }

    public function occurredOn() : \DateTimeInterface
    {
        return $this->occurredOn;
    }
}
