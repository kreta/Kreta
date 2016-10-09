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

namespace Spec\Kreta\TaskManager\Domain\Model\Organization;

use Kreta\TaskManager\Domain\Model\Organization\OrganizationParticipantEmail;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationParticipantId;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationParticipantUsername;
use PhpSpec\ObjectBehavior;

class OrganizationParticipantSpec extends ObjectBehavior
{
    function let(
        OrganizationParticipantId $id,
        OrganizationParticipantEmail $email,
        OrganizationParticipantUsername $username
    ) {
        $this->beConstructedWith($id, $email, $username);
    }
}
