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

namespace Kreta\Notifier\Application\Command\Inbox;

use Kreta\Notifier\Domain\Model\Inbox\NotificationId;
use Kreta\Notifier\Domain\Model\Inbox\UserId;
use Kreta\Notifier\Domain\Model\Inbox\UserRepository;

class ReadNotificationHandler
{
    private $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(ReadNotificationCommand $command) : void
    {
        $id = UserId::generate($command->userId());
        $notificationId = NotificationId::generate($command->notificationId());

        $user = $this->repository->get($id);
        $notification = $user->notification($notificationId);
        $user->readNotification($notification);
        $this->repository->save($user);
    }
}
