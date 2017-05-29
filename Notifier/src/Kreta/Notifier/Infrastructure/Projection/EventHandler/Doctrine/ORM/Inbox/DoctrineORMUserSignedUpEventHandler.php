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
use Kreta\Notifier\Domain\Model\Inbox\UserAlreadyExists;
use Kreta\Notifier\Domain\Model\Inbox\UserSignedUp;
use Kreta\Notifier\Infrastructure\Projection\ReadModel\Inbox\User;
use Kreta\SharedKernel\Domain\Model\DomainEvent;
use Kreta\SharedKernel\Projection\EventHandler;

class DoctrineORMUserSignedUpEventHandler implements EventHandler
{
    private $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    public function eventType() : string
    {
        return UserSignedUp::class;
    }

    public function handle(DomainEvent $event) : void
    {
        $user = $this->manager->getRepository(User::class)->find($event->userId());

        if ($user instanceof User) {
            throw new UserAlreadyExists($event->userId());
        }
        $user = new User($event->userId()->id());

        $this->manager->persist($user);
        $this->manager->flush();
    }
}
