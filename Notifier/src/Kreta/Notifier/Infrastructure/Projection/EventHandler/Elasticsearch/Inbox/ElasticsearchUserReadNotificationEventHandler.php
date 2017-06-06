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

namespace Kreta\Notifier\Infrastructure\Projection\EventHandler\Elasticsearch\Inbox;

use Kreta\Notifier\Domain\Model\Inbox\NotificationStatus;
use Kreta\Notifier\Domain\Model\Inbox\UserReadNotification;
use Kreta\SharedKernel\Domain\Model\DomainEvent;
use Kreta\SharedKernel\Projection\EventHandler;
use ONGR\ElasticsearchBundle\Service\Repository;

class ElasticsearchUserReadNotificationEventHandler implements EventHandler
{
    private $repository;

    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
    }

    public function eventType() : string
    {
        return UserReadNotification::class;
    }

    public function handle(DomainEvent $event) : void
    {
        $user = $this->repository->find($event->userId()->id());

        foreach ($user->notifications as $index => $notification) {
            if ($event->notificationId()->id() !== $notification->id) {
                continue;
            }
            $user->notifications[$index]->readOn = $event->occurredOn();
            $user->notifications[$index]->status = (NotificationStatus::read())->status();
        }

        $this->repository->update($event->userId()->id(), ['notifications' => $user->notifications]);
    }
}
