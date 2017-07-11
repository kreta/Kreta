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

use Kreta\Notifier\Domain\Model\Inbox\Notification\NotificationId;
use Kreta\Notifier\Domain\Model\Inbox\Notification\NotificationRepository;
use Kreta\Notifier\Domain\Model\Inbox\UserId;
use Kreta\Notifier\Domain\Model\Inbox\UserRepository;

class MarkAsReadNotification
{
    private $repository;
    private $userRepository;

    public function __construct(NotificationRepository $repository, UserRepository $userRepository)
    {
        $this->repository = $repository;
        $this->userRepository = $userRepository;
    }

    public function __invoke(MarkAsReadNotificationCommand $command) : void
    {
        $id = NotificationId::generate($command->notificationId());
        $userId = UserId::generate($command->userId());

        $this->checkUserExists($userId);

        $notification = $this->repository->get($id);
        $notification->markAsRead();

        $this->repository->save($notification);
    }

    private function checkUserExists(UserId $userId) : void
    {
        $this->userRepository->get($userId);
    }
}
