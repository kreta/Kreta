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

use Kreta\Notifier\Application\Command\Notification\MarkAsUnreadNotificationCommand;
use Kreta\Notifier\Domain\Model\Notification\Notification;
use Kreta\Notifier\Domain\Model\Notification\NotificationDoesNotExistException;
use Kreta\Notifier\Domain\Model\Notification\NotificationId;
use Kreta\Notifier\Domain\Model\Notification\NotificationRepository;
use Kreta\Notifier\Domain\Model\User\User;
use Kreta\Notifier\Domain\Model\User\UserDoesNotExistException;
use Kreta\Notifier\Domain\Model\User\UserId;
use Kreta\Notifier\Domain\Model\User\UserRepository;
use PhpSpec\ObjectBehavior;

class MarkAsUnreadNotificationHandlerSpec extends ObjectBehavior
{
    private $id;
    private $userId;

    function let(
        NotificationRepository $repository,
        UserRepository $userRepository,
        MarkAsUnreadNotificationCommand $command
    ) {
        $this->beConstructedWith($repository, $userRepository);

        $command->id()->shouldBeCalled()->willReturn('notification-id');
        $command->userId()->shouldBeCalled()->willReturn('user-id');

        $this->id = NotificationId::generate('notification-id');
        $this->userId = UserId::generate('user-id');
    }

    function it_marks_as_unread_notification(
        MarkAsUnreadNotificationCommand $command,
        NotificationRepository $repository,
        Notification $notification,
        UserRepository $userRepository,
        User $user
    ) {
        $repository->notificationOfId($this->id)->shouldBeCalled()->willReturn($notification);
        $userRepository->userOfId($this->userId)->shouldBeCalled()->willReturn($user);
        $notification->markAsUnread()->shouldBeCalled();
        $repository->persist($notification)->shouldBeCalled();
        $this->__invoke($command);
    }

    function it_does_not_mark_as_unread_notification_when_the_notification_does_not_exist(
        MarkAsUnreadNotificationCommand $command,
        NotificationRepository $repository
    ) {
        $repository->notificationOfId($this->id)->shouldBeCalled()->willReturn(null);
        $this->shouldThrow(NotificationDoesNotExistException::class)->during__invoke($command);
    }

    function it_does_not_publish_notification_when_the_user_does_not_exist(
        MarkAsUnreadNotificationCommand $command,
        NotificationRepository $repository,
        Notification $notification,
        UserRepository $userRepository
    ) {
        $repository->notificationOfId($this->id)->shouldBeCalled()->willReturn($notification);
        $userRepository->userOfId($this->userId)->shouldBeCalled()->willReturn(null);
        $this->shouldThrow(UserDoesNotExistException::class)->during__invoke($command);
    }
}
