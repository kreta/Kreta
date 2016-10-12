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

class OrganizationEdited implements DomainEvent
{
    private $organizationId;
    private $name;
    private $slug;
    private $occurredOn;

    public function __construct(OrganizationId $organizationId, OrganizationName $name, Slug $slug)
    {
        $this->organizationId = $organizationId;
        $this->name = $name;
        $this->slug = $slug;
        $this->occurredOn = new \DateTimeImmutable();
    }

    public function id() : OrganizationId
    {
        return $this->organizationId;
    }

    public function name() : OrganizationName
    {
        return $this->name;
    }

    public function slug() : Slug
    {
        return $this->slug;
    }

    public function occurredOn() : \DateTimeInterface
    {
        return $this->occurredOn;
    }
}
