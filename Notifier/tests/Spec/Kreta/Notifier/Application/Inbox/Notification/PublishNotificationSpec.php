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

use Kreta\Notifier\Application\Inbox\Notification\PublishNotificationCommand;
use Kreta\Notifier\Domain\Model\Inbox\Notification\Notification;
use Kreta\Notifier\Domain\Model\Inbox\Notification\NotificationAlreadyExists;
use Kreta\Notifier\Domain\Model\Inbox\Notification\NotificationDoesNotExist;
use Kreta\Notifier\Domain\Model\Inbox\Notification\NotificationId;
use Kreta\Notifier\Domain\Model\Inbox\Notification\NotificationRepository;
use Kreta\Notifier\Domain\Model\Inbox\User;
use Kreta\Notifier\Domain\Model\Inbox\UserDoesNotExist;
use Kreta\Notifier\Domain\Model\Inbox\UserId;
use Kreta\Notifier\Domain\Model\Inbox\UserRepository;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class PublishNotificationSpec extends ObjectBehavior
{
    private $notificationId;
    private $userId;

    function let(
        NotificationRepository $repository,
        UserRepository $userRepository,
        PublishNotificationCommand $command
    ) {
        $this->beConstructedWith($repository, $userRepository);

        $command->notificationId()->shouldBeCalled()->willReturn('notification-id');
        $command->userId()->shouldBeCalled()->willReturn('user-id');
        $command->body()->shouldBeCalled()->willReturn('The notification body');

        $this->notificationId = NotificationId::generate('notification-id');
        $this->userId = UserId::generate('user-id');
    }

    function it_does_not_publish_notification_when_the_notification_already_exists(
        PublishNotificationCommand $command,
        NotificationRepository $repository,
        Notification $notification,
        NotificationId $notificationId
    ) {
        $repository->get($this->notificationId)->shouldBeCalled()->willReturn($notification);
        $notification->id()->shouldBeCalled()->willReturn($notificationId);
        $notificationId->id()->willReturn('notification-id');
        $this->shouldThrow(NotificationAlreadyExists::class)->during__invoke($command);
    }

    function it_does_not_publish_notification_when_the_user_does_not_exist(
        PublishNotificationCommand $command,
        NotificationRepository $repository,
        UserRepository $userRepository
    ) {
        $repository->get($this->notificationId)->shouldBeCalled()->willThrow(NotificationDoesNotExist::class);
        $userRepository->get($this->userId)->shouldBeCalled()->willThrow(UserDoesNotExist::class);
        $this->shouldThrow(UserDoesNotExist::class)->during__invoke($command);
    }

    function it_publishes_notification(
        PublishNotificationCommand $command,
        NotificationRepository $repository,
        UserRepository $userRepository,
        User $user
    ) {
        $repository->get($this->notificationId)->shouldBeCalled()->willThrow(NotificationDoesNotExist::class);
        $userRepository->get($this->userId)->shouldBeCalled()->willReturn($user);
        $repository->save(Argument::type(Notification::class))->shouldBeCalled();
        $this->__invoke($command);
    }
}
