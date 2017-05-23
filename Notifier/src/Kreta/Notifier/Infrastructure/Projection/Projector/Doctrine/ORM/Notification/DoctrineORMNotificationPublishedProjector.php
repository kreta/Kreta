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
use Kreta\Notifier\Domain\Model\Notification\NotificationPublished;
use Kreta\Notifier\Infrastructure\Projection\ReadModel\Notification;
use Kreta\SharedKernel\Domain\Model\DomainEvent;
use Kreta\SharedKernel\Projection\Projector;

class DoctrineORMNotificationPublishedProjector implements Projector
{
    private $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    public function eventType() : string
    {
        NotificationPublished::class;
    }

    public function project(DomainEvent $event) : void
    {
        $notification = new Notification(
            $event->id(),
            $event->body(),
            $event->owner(),
            $event->occurredOn(),
            $event->readOn(),
            $event->status()
        );

        $this->manager->persist($notification);
        $this->manager->flush();
    }
}
