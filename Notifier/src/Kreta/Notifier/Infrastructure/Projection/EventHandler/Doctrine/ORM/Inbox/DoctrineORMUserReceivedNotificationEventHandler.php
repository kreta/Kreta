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

namespace Kreta\Notifier\Infrastructure\Projection\EventHandler\Doctrine\ORM\Inbox;

use Doctrine\ORM\EntityManagerInterface;
use Kreta\Notifier\Domain\Model\Inbox\UserReceivedNotification;
use Kreta\Notifier\Infrastructure\Projection\ReadModel\Inbox\Notification;
use Kreta\Notifier\Infrastructure\Projection\ReadModel\Inbox\User;
use Kreta\SharedKernel\Domain\Model\DomainEvent;
use Kreta\SharedKernel\Projection\EventHandler;

class DoctrineORMUserReceivedNotificationEventHandler implements EventHandler
{
    private $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    public function eventType() : string
    {
        return UserReceivedNotification::class;
    }

    public function handle(DomainEvent $event) : void
    {
        $user = $this->manager->getRepository(User::class)->find($event->userId());

        $user->notifications[] = new Notification(
            $event->notificationId()->id(),
            $event->body()->body(),
            $event->occurredOn()
        );

        $this->manager->persist($user);
        $this->manager->flush();
    }
}
