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

namespace Kreta\TaskManager\Tests\Double\Domain\Model;

use Kreta\TaskManager\Domain\Model\Organization\OrganizationParticipantEmail;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationParticipantId;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationParticipantUsername;
use Kreta\TaskManager\Domain\Model\Organization\Participant;

class ParticipantStub extends Participant
{
    public function __construct(
        OrganizationParticipantId $id,
        OrganizationParticipantEmail $email,
        OrganizationParticipantUsername $username
    ) {
        parent::__construct($id, $email, $username);
    }
}
