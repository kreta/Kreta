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

namespace Spec\Kreta\Notifier\Application\Inbox\Notification;

use Kreta\Notifier\Application\Inbox\Notification\MarkAsUnreadNotificationCommand;
use Kreta\Notifier\Domain\Model\Inbox\Notification\Notification;
use Kreta\Notifier\Domain\Model\Inbox\Notification\NotificationDoesNotExist;
use Kreta\Notifier\Domain\Model\Inbox\Notification\NotificationId;
use Kreta\Notifier\Domain\Model\Inbox\Notification\NotificationRepository;
use Kreta\Notifier\Domain\Model\Inbox\User;
use Kreta\Notifier\Domain\Model\Inbox\UserDoesNotExist;
use Kreta\Notifier\Domain\Model\Inbox\UserId;
use Kreta\Notifier\Domain\Model\Inbox\UserRepository;
use PhpSpec\ObjectBehavior;

class MarkAsUnreadNotificationSpec extends ObjectBehavior
{
    private $notificationId;
    private $userId;

    function let(
        NotificationRepository $repository,
        UserRepository $userRepository,
        MarkAsUnreadNotificationCommand $command
    ) {
        $this->beConstructedWith($repository, $userRepository);

        $command->notificationId()->shouldBeCalled()->willReturn('notification-id');
        $command->userId()->shouldBeCalled()->willReturn('user-id');

        $this->notificationId = NotificationId::generate('notification-id');
        $this->userId = UserId::generate('user-id');
    }

    function it_does_not_mark_as_unread_notification_when_the_user_does_not_exist(
        MarkAsUnreadNotificationCommand $command,
        UserRepository $userRepository
    ) {
        $userRepository->get($this->userId)->shouldBeCalled()->willThrow(UserDoesNotExist::class);
        $this->shouldThrow(UserDoesNotExist::class)->during__invoke($command);
    }

    function it_does_not_mark_as_unread_notification_when_the_notification_does_not_exist(
        MarkAsUnreadNotificationCommand $command,
        NotificationRepository $repository,
        UserRepository $userRepository,
        User $user
    ) {
        $userRepository->get($this->userId)->shouldBeCalled()->willReturn($user);
        $repository->get($this->notificationId)->shouldBeCalled()->willThrow(NotificationDoesNotExist::class);
        $this->shouldThrow(NotificationDoesNotExist::class)->during__invoke($command);
    }

    function it_marks_as_unread_notification(
        MarkAsUnreadNotificationCommand $command,
        Notification $notification,
        NotificationRepository $repository,
        UserRepository $userRepository,
        User $user
    ) {
        $userRepository->get($this->userId)->shouldBeCalled()->willReturn($user);
        $repository->get($this->notificationId)->shouldBeCalled()->willReturn($notification);
        $notification->markAsUnread()->shouldBeCalled();
        $repository->save($notification)->shouldBeCalled();
        $this->__invoke($command);
    }
}
