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

use Kreta\TaskManager\Domain\Model\Organization\Member;
use Kreta\TaskManager\Domain\Model\Organization\MemberId;
use PhpSpec\ObjectBehavior;

class MemberSpec extends ObjectBehavior
{
    function let(MemberId $id)
    {
        $id->id()->willReturn('member-id');
        $this->beConstructedWith($id);
    }

    function it_can_be_created()
    {
        $this->shouldHaveType(Member::class);
        $this->id()->shouldReturnAnInstanceOf(MemberId::class);
        $this->__toString()->shouldReturn('member-id');
    }
}
