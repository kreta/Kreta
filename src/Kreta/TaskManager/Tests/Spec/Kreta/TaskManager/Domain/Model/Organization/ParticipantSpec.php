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
use Kreta\TaskManager\Domain\Model\Organization\Participant;
use Kreta\TaskManager\Tests\Double\Domain\Model\ParticipantStub;
use PhpSpec\ObjectBehavior;

class ParticipantSpec extends ObjectBehavior
{
    function let(
        OrganizationParticipantId $id,
        OrganizationParticipantEmail $email,
        OrganizationParticipantUsername $username
    ) {
        $id->id()->willReturn('organization-participant-id');
        $this->beAnInstanceOf(ParticipantStub::class);
        $this->beConstructedWith($id, $email, $username);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Participant::class);
    }

    function it_gets_id()
    {
        $this->id()->shouldReturnAnInstanceOf(OrganizationParticipantId::class);
        $this->__toString()->shouldReturn('organization-participant-id');
    }

    function it_gets_email()
    {
        $this->email()->shouldReturnAnInstanceOf(OrganizationParticipantEmail::class);
    }

    function it_gets_username()
    {
        $this->username()->shouldReturnAnInstanceOf(OrganizationParticipantUsername::class);
    }

    function it_changes_email(OrganizationParticipantEmail $email, OrganizationParticipantEmail $email2)
    {
        $this->email()->shouldReturn($email);
        $this->changeEmail($email2);
        $this->email()->shouldReturn($email2);
    }

    function it_changes_username(OrganizationParticipantUsername $username, OrganizationParticipantUsername $username2)
    {
        $this->username()->shouldReturn($username);
        $this->changeUsername($username2);
        $this->username()->shouldReturn($username2);
    }
}
