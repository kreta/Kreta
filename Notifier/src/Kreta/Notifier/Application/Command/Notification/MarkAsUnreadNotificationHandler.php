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

namespace Kreta\Notifier\Application\Command\Notification;

use Kreta\Notifier\Domain\Model\Notification\Notification;
use Kreta\Notifier\Domain\Model\Notification\NotificationDoesNotExistException;
use Kreta\Notifier\Domain\Model\Notification\NotificationId;
use Kreta\Notifier\Domain\Model\Notification\NotificationRepository;
use Kreta\Notifier\Domain\Model\User\UserDoesNotExistException;
use Kreta\Notifier\Domain\Model\User\UserId;
use Kreta\Notifier\Domain\Model\User\UserRepository;

class MarkAsUnreadNotificationHandler
{
    private $repository;
    private $userRepository;

    public function __construct(NotificationRepository $repository, UserRepository $userRepository)
    {
        $this->repository = $repository;
        $this->userRepository = $userRepository;
    }

    public function __invoke(MarkAsUnreadNotificationCommand $command) : void
    {
        $id = NotificationId::generate($command->id());
        $userId = UserId::generate($command->userId());

        $notification = $this->repository->notificationOfId($id);
        $this->checkNotificationExists($notification);
        $this->checkUserExists($userId);

        $notification->markAsUnread();

        $this->repository->persist($notification);
    }

    private function checkNotificationExists(?Notification $notification) : void
    {
        if (null === $notification) {
            throw new NotificationDoesNotExistException();
        }
    }

    private function checkUserExists(UserId $userId) : void
    {
        $user = $this->userRepository->userOfId($userId);
        if (null === $user) {
            throw new UserDoesNotExistException();
        }
    }
}
