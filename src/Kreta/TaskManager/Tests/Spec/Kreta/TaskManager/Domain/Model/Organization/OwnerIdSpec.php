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

use Kreta\TaskManager\Domain\Model\Organization\MemberId;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationId;
use Kreta\TaskManager\Domain\Model\Organization\OwnerId;
use Kreta\TaskManager\Domain\Model\User\UserId;
use PhpSpec\ObjectBehavior;

class OwnerIdSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(OwnerId::class);
    }

    function it_extends_member_id()
    {
        $this->shouldHaveType(MemberId::class);
    }

    function it_generates(UserId $userId, OrganizationId $organizationId)
    {
        $this->beConstructedGenerate($userId, $organizationId);
        $this->userId()->shouldReturn($userId);
        $this->organizationId()->shouldReturn($organizationId);
    }
}
