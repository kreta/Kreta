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

namespace Spec\Kreta\TaskManager\Application\User;

use Kreta\TaskManager\Application\User\AddUserCommand;
use Kreta\TaskManager\Application\User\AddUserHandler;
use Kreta\TaskManager\Domain\Model\User\User;
use Kreta\TaskManager\Domain\Model\User\UserAlreadyExistsException;
use Kreta\TaskManager\Domain\Model\User\UserId;
use Kreta\TaskManager\Domain\Model\User\UserRepository;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class AddUserHandlerSpec extends ObjectBehavior
{
    function let(UserRepository $repository)
    {
        $this->beConstructedWith($repository);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(AddUserHandler::class);
    }

    function it_adds_user(AddUserCommand $command, UserRepository $repository)
    {
        $command->userId()->shouldBeCalled()->willReturn('user-id');
        $repository->userOfId(UserId::generate('user-id'))->shouldBeCalled()->willReturn(null);
        $repository->persist(Argument::type(User::class))->shouldBeCalled();
        $this->__invoke($command);
    }

    function it_does_not_add_user_when_the_user_already_exists(
        AddUserCommand $command,
        UserRepository $repository,
        User $user
    ) {
        $command->userId()->shouldBeCalled()->willReturn('user-id');
        $repository->userOfId(UserId::generate('user-id'))->shouldBeCalled()->willReturn($user);
        $user->id()->shouldBeCalled()->willReturn(UserId::generate('user-id'));
        $this->shouldThrow(UserAlreadyExistsException::class)->during__invoke($command);
    }
}
