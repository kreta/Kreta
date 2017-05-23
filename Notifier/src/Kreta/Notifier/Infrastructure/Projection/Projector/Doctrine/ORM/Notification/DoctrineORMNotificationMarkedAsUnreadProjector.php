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

namespace Kreta\TaskManager\Infrastructure\Projection\Projector\Doctrine\ORM\Notification;

use Doctrine\ORM\EntityManagerInterface;
use Kreta\Notifier\Domain\Model\Notification\NotificationMarkedAsUnread;
use Kreta\Notifier\Domain\Model\Notification\NotificationStatus;
use Kreta\Notifier\Infrastructure\Projection\ReadModel\Notification;
use Kreta\SharedKernel\Domain\Model\DomainEvent;
use Kreta\SharedKernel\Projection\Projector;

class DoctrineORMNotificationMarkedAsUnreadProjector implements Projector
{
    private $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    public function eventType() : string
    {
        NotificationMarkedAsUnread::class;
    }

    public function project(DomainEvent $event) : void
    {
        $notification = $this->manager->getRepository(Notification::class)->find($event->id());
        $notification->readOn = null;
        $notification->status = (NotificationStatus::unread())->status();
        $this->manager->persist($notification);
        $this->manager->flush();
    }
}
