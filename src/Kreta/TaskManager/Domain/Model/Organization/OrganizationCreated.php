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

class OrganizationCreated implements DomainEvent
{
    private $occurredOn;
    private $organizationId;

    public function __construct(OrganizationId $organizationId)
    {
        $this->organizationId = $organizationId;
        $this->occurredOn = new \DateTimeImmutable();
    }

    public function occurredOn() : \DateTimeInterface
    {
        return $this->occurredOn;
    }

    public function organizationId() : OrganizationId
    {
        return $this->organizationId;
    }
}
