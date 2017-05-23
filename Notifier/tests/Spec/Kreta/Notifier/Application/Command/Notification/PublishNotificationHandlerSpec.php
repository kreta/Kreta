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

namespace Spec\Kreta\Notifier\Application\Command\Notification;

use Kreta\Notifier\Application\Command\Notification\PublishNotificationCommand;
use Kreta\Notifier\Domain\Model\Notification\Notification;
use Kreta\Notifier\Domain\Model\Notification\NotificationRepository;
use Kreta\Notifier\Domain\Model\User\User;
use Kreta\Notifier\Domain\Model\User\UserDoesNotExistException;
use Kreta\Notifier\Domain\Model\User\UserId;
use Kreta\Notifier\Domain\Model\User\UserRepository;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class PublishNotificationHandlerSpec extends ObjectBehavior
{
    function let(NotificationRepository $repository, UserRepository $userRepository)
    {
        $this->beConstructedWith($repository, $userRepository);
    }

    function it_publishes_notification(
        PublishNotificationCommand $command,
        NotificationRepository $repository,
        UserRepository $userRepository,
        User $user
    ) {
        $command->id()->shouldBeCalled()->willReturn('notification-id');
        $command->body()->shouldBeCalled()->willReturn('The notification body');
        $command->userId()->shouldBeCalled()->willReturn('user-id');

        $userId = UserId::generate('user-id');

        $userRepository->userOfId($userId)->shouldBeCalled()->willReturn($user);
        $repository->persist(Argument::type(Notification::class))->shouldBeCalled();
        $this->__invoke($command);
    }

    function it_does_not_publish_notification_because_the_user_does_not_exist(
        PublishNotificationCommand $command,
        UserRepository $userRepository
    ) {
        $command->id()->shouldBeCalled()->willReturn('notification-id');
        $command->body()->shouldBeCalled()->willReturn('The notification body');
        $command->userId()->shouldBeCalled()->willReturn('user-id');

        $userId = UserId::generate('user-id');

        $userRepository->userOfId($userId)->shouldBeCalled()->willReturn(null);
        $this->shouldThrow(UserDoesNotExistException::class)->during__invoke($command);
    }
}
