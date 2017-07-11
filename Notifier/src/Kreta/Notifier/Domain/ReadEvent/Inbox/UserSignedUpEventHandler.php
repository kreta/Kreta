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

namespace Kreta\Notifier\Domain\ReadEvent\Inbox;

use Kreta\Notifier\Domain\Model\Inbox\UserSignedUp;
use Kreta\Notifier\Domain\ReadModel\Inbox\User;
use Kreta\Notifier\Domain\ReadModel\Inbox\UserView;
use Kreta\SharedKernel\Domain\Model\DomainEvent;
use Kreta\SharedKernel\Domain\ReadEvent\EventHandler;

class UserSignedUpEventHandler implements EventHandler
{
    private $view;

    public function __construct(UserView $view)
    {
        $this->view = $view;
    }

    public function isSubscribeTo() : string
    {
        return UserSignedUp::class;
    }

    public function handle(DomainEvent $event) : void
    {
        $user = new User($event->userId()->id());

        $this->view->save($user);
    }
}
