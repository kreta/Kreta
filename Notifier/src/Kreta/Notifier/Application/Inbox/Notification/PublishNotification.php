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

namespace Kreta\Notifier\Application\Inbox\Notification;

use Kreta\Notifier\Domain\Model\Inbox\Notification\Notification;
use Kreta\Notifier\Domain\Model\Inbox\Notification\NotificationAlreadyExists;
use Kreta\Notifier\Domain\Model\Inbox\Notification\NotificationBody;
use Kreta\Notifier\Domain\Model\Inbox\Notification\NotificationDoesNotExist;
use Kreta\Notifier\Domain\Model\Inbox\Notification\NotificationId;
use Kreta\Notifier\Domain\Model\Inbox\Notification\NotificationRepository;
use Kreta\Notifier\Domain\Model\Inbox\Notification\NotificationType;
use Kreta\Notifier\Domain\Model\Inbox\UserId;
use Kreta\Notifier\Domain\Model\Inbox\UserRepository;

class PublishNotification
{
    private $repository;
    private $userRepository;

    public function __construct(NotificationRepository $repository, UserRepository $userRepository)
    {
        $this->repository = $repository;
        $this->userRepository = $userRepository;
    }

    public function __invoke(PublishNotificationCommand $command) : void
    {
        $id = NotificationId::generate($command->notificationId());
        $userId = UserId::generate($command->userId());
        $type = new NotificationType($command->type());
        $body = new NotificationBody($command->body());

        $this->checkNotificationDoesNotExist($id);
        $this->checkUserExists($userId);

        $notification = Notification::broadcast($id, $userId, $type, $body);

        $this->repository->save($notification);
    }

    private function checkNotificationDoesNotExist(NotificationId $notificationId) : void
    {
        try {
            $notification = $this->repository->get($notificationId);
            if ($notification instanceof Notification) {
                throw new NotificationAlreadyExists($notification->id());
            }
        } catch (NotificationDoesNotExist $exception) {
        }
    }

    private function checkUserExists(UserId $userId) : void
    {
        $this->userRepository->get($userId);
    }
}
