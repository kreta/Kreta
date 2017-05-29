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

namespace Spec\Kreta\Notifier\Application\Command\Inbox;

use Kreta\Notifier\Application\Command\Inbox\UnreadNotificationCommand;
use Kreta\Notifier\Domain\Model\Inbox\Notification;
use Kreta\Notifier\Domain\Model\Inbox\NotificationId;
use Kreta\Notifier\Domain\Model\Inbox\User;
use Kreta\Notifier\Domain\Model\Inbox\UserId;
use Kreta\Notifier\Domain\Model\Inbox\UserRepository;
use PhpSpec\ObjectBehavior;

class UnreadNotificationHandlerSpec extends ObjectBehavior
{
    private $notificationId;
    private $userId;

    function let(UserRepository $repository, UnreadNotificationCommand $command)
    {
        $this->beConstructedWith($repository);

        $command->notificationId()->shouldBeCalled()->willReturn('notification-id');
        $command->userId()->shouldBeCalled()->willReturn('user-id');

        $this->notificationId = NotificationId::generate('notification-id');
        $this->userId = UserId::generate('user-id');
    }

    function it_unreads_notification(
        UnreadNotificationCommand $command,
        Notification $notification,
        UserRepository $repository,
        User $user
    ) {
        $repository->get($this->userId)->shouldBeCalled()->willReturn($user);
        $user->notification($this->notificationId)->shouldBeCalled()->willReturn($notification);
        $user->unreadNotification($notification)->shouldBeCalled();
        $repository->save($user)->shouldBeCalled();
        $this->__invoke($command);
    }
}
