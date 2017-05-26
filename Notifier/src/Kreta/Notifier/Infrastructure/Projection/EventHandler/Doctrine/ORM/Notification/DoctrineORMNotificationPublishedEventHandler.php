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

namespace Kreta\Notifier\Infrastructure\Projection\EventHandler\Doctrine\ORM\Notification;

use Doctrine\ORM\EntityManagerInterface;
use Kreta\Notifier\Domain\Model\Notification\NotificationPublished;
use Kreta\Notifier\Infrastructure\Projection\ReadModel\Notification\Notification;
use Kreta\SharedKernel\Domain\Model\DomainEvent;
use Kreta\SharedKernel\Projection\EventHandler;

class DoctrineORMNotificationPublishedEventHandler implements EventHandler
{
    private $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    public function eventType() : string
    {
        return NotificationPublished::class;
    }

    public function handle(DomainEvent $event) : void
    {
        $notification = new Notification(
            $event->id()->id(),
            $event->body()->body(),
            $event->owner()->userId()->id(),
            $event->occurredOn()
        );

        $this->manager->persist($notification);
        $this->manager->flush();
    }
}
