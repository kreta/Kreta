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

namespace Spec\Kreta\Notifier\Application\Inbox;

use Kreta\Notifier\Application\Inbox\SignUpUserCommand;
use Kreta\Notifier\Domain\Model\Inbox\User;
use Kreta\Notifier\Domain\Model\Inbox\UserAlreadyExists;
use Kreta\Notifier\Domain\Model\Inbox\UserDoesNotExist;
use Kreta\Notifier\Domain\Model\Inbox\UserId;
use Kreta\Notifier\Domain\Model\Inbox\UserRepository;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class SignUpUserSpec extends ObjectBehavior
{
    function let(UserRepository $repository)
    {
        $this->beConstructedWith($repository);
    }

    function it_signs_up_user(SignUpUserCommand $command, UserRepository $repository)
    {
        $command->userId()->shouldBeCalled()->willReturn('user-id');
        $repository->get(UserId::generate('user-id'))->willThrow(UserDoesNotExist::class);
        $repository->save(Argument::type(User::class))->shouldBeCalled();
        $this->__invoke($command);
    }

    function it_does_not_sign_up_user_when_the_user_already_exists(
        SignUpUserCommand $command,
        UserRepository $repository,
        User $user
    ) {
        $command->userId()->shouldBeCalled()->willReturn('user-id');
        $repository->get(UserId::generate('user-id'))->shouldBeCalled()->willReturn($user);
        $user->id()->shouldBeCalled()->willReturn(UserId::generate('user-id'));
        $this->shouldThrow(UserAlreadyExists::class)->during__invoke($command);
    }
}
