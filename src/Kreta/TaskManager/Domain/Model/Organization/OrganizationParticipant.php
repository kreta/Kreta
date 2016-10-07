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

class OrganizationParticipant extends Participant
{
    private $id;

    public function __construct(OrganizationParticipantId $id)
    {
        $this->id = $id;
    }

    public function id() : OrganizationParticipantId
    {
        return $this->id;
    }

    public function __toString()
    {
        return (string) $this->id->id();
    }
}
