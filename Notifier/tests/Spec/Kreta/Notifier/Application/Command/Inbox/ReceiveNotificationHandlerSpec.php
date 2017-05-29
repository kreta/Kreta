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

use Kreta\Notifier\Application\Command\Inbox\ReceiveNotificationCommand;
use Kreta\Notifier\Domain\Model\Inbox\NotificationBody;
use Kreta\Notifier\Domain\Model\Inbox\NotificationId;
use Kreta\Notifier\Domain\Model\Inbox\User;
use Kreta\Notifier\Domain\Model\Inbox\UserId;
use Kreta\Notifier\Domain\Model\Inbox\UserRepository;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ReceiveNotificationHandlerSpec extends ObjectBehavior
{
    private $notificationId;
    private $userId;

    function let(UserRepository $repository, ReceiveNotificationCommand $command)
    {
        $this->beConstructedWith($repository);

        $command->notificationId()->shouldBeCalled()->willReturn('notification-id');
        $command->body()->shouldBeCalled()->willReturn('The notification body');
        $command->userId()->shouldBeCalled()->willReturn('user-id');

        $this->notificationId = NotificationId::generate('notification-id');
        $this->userId = UserId::generate('user-id');
    }

    function it_receives_notification(
        ReceiveNotificationCommand $command,
        UserRepository $repository,
        User $user
    ) {
        $repository->get($this->userId)->shouldBeCalled()->willReturn($user);
        $user->receiveNotification($this->notificationId, Argument::type(NotificationBody::class))->shouldBeCalled();
        $repository->save($user)->shouldBeCalled();
        $this->__invoke($command);
    }
}
