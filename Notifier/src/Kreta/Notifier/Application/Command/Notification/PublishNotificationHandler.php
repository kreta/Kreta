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
use Kreta\Notifier\Domain\Model\Notification\NotificationAlreadyExistsException;
use Kreta\Notifier\Domain\Model\Notification\NotificationBody;
use Kreta\Notifier\Domain\Model\Notification\NotificationId;
use Kreta\Notifier\Domain\Model\Notification\NotificationOwner;
use Kreta\Notifier\Domain\Model\Notification\NotificationOwnerId;
use Kreta\Notifier\Domain\Model\Notification\NotificationRepository;
use Kreta\Notifier\Domain\Model\User\UserDoesNotExistException;
use Kreta\Notifier\Domain\Model\User\UserId;
use Kreta\Notifier\Domain\Model\User\UserRepository;

class PublishNotificationHandler
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
        $id = NotificationId::generate($command->id());
        $body = new NotificationBody($command->body());
        $userId = UserId::generate($command->userId());

        $this->checkNotificationExists($id);
        $this->checkUserExists($userId);

        $ownerId = NotificationOwnerId::generate();
        $owner = new NotificationOwner($ownerId, $userId);

        $notification = Notification::broadcast($id, $owner, $body);

        $this->repository->persist($notification);
    }

    private function checkNotificationExists(NotificationId $notificationId)
    {
        $notification = $this->repository->notificationOfId($notificationId);
        if ($notification instanceof Notification) {
            throw new NotificationAlreadyExistsException();
        }
    }

    private function checkUserExists(UserId $userId)
    {
        $user = $this->userRepository->userOfId($userId);
        if (null === $user) {
            throw new UserDoesNotExistException();
        }
    }
}
