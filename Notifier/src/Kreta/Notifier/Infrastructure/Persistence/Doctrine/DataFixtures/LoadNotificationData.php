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

namespace Kreta\Notifier\Infrastructure\Persistence\Doctrine\DataFixtures;

use Doctrine\Common\Persistence\ObjectManager;
use Kreta\Notifier\Application\Command\Inbox\ReadNotificationCommand;
use Kreta\Notifier\Application\Command\Inbox\ReceiveNotificationCommand;
use Kreta\Notifier\Application\Command\Inbox\UnreadNotificationCommand;
use Kreta\SharedKernel\Infrastructure\Persistence\Doctrine\DataFixtures\AbstractFixture;

class LoadNotificationData extends AbstractFixture
{
    protected function type() : string
    {
        return 'notification';
    }

    public function getOrder() : int
    {
        return 2;
    }

    public function load(ObjectManager $manager) : void
    {
        $i = 0;
        while ($i < $this->amount()) {
            $userId = $this->getRandomUserByIndex($i);
            $notificationId = $this->fakeIds()[$i];
            $body = 'The notification body ' . $i;

            $receiveNotificationCommand = new ReceiveNotificationCommand($body, $userId, $notificationId);
            $this->commandBus()->handle($receiveNotificationCommand);

            $readNotificationCommand = new ReadNotificationCommand($notificationId, $userId);
            $this->commandBus()->handle($readNotificationCommand);

            if ($i % 2 === 0) {
                $unreadNotificationCommand = new UnreadNotificationCommand($notificationId, $userId);
                $this->commandBus()->handle($unreadNotificationCommand);
            }
            ++$i;
        }
    }
}
