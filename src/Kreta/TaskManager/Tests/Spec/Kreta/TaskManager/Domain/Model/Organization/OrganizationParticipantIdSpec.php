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

use Kreta\TaskManager\Domain\Model\Organization\OrganizationParticipantId;
use Kreta\TaskManager\Domain\Model\Organization\ParticipantId;
use Kreta\TaskManager\Domain\Model\User\UserId;
use PhpSpec\ObjectBehavior;

class OrganizationParticipantIdSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(OrganizationParticipantId::class);
    }

    function it_extends_participant_id()
    {
        $this->shouldHaveType(ParticipantId::class);
    }

    function it_generates(UserId $userId)
    {
        $this->beConstructedGenerate($userId);
        $this::generate($userId)->shouldReturnAnInstanceOf(OrganizationParticipantId::class);
    }
}
