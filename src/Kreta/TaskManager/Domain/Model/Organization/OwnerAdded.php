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

class OwnerAdded implements DomainEvent
{
    private $organizationId;
    private $ownerId;
    private $occurredOn;

    public function __construct(OrganizationId $organizationId, OwnerId $ownerId)
    {
        $this->organizationId = $organizationId;
        $this->ownerId = $ownerId;
        $this->occurredOn = new \DateTimeImmutable();
    }

    public function organizationId() : OrganizationId
    {
        return $this->organizationId;
    }

    public function ownerId() : OwnerId
    {
        return $this->ownerId;
    }

    public function occurredOn() : \DateTimeInterface
    {
        return $this->occurredOn;
    }
}
