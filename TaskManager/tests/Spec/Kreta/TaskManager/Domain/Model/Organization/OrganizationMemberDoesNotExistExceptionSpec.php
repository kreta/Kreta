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

use Kreta\SharedKernel\Domain\Model\Exception;
use Kreta\TaskManager\Domain\Model\Organization\OrganizationMemberDoesNotExistException;
use Kreta\TaskManager\Domain\Model\User\UserId;
use PhpSpec\ObjectBehavior;

class OrganizationMemberDoesNotExistExceptionSpec extends ObjectBehavior
{
    function let(UserId $userId)
    {
        $this->beConstructedWith($userId);
        $userId->id()->shouldBeCalled()->willReturn('user-id');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(OrganizationMemberDoesNotExistException::class);
        $this->shouldHaveType(Exception::class);
    }

    function it_should_return_message()
    {
        $this->getMessage()->shouldReturn('The given user-id user is not an organization member');
    }
}
