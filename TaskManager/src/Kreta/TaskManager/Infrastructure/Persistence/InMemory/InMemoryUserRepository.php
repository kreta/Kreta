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

namespace Kreta\TaskManager\Infrastructure\Persistence\InMemory;

use BenGorUser\User\Infrastructure\Domain\Model\UserEventBus;
use Kreta\TaskManager\Domain\Model\User\User;
use Kreta\TaskManager\Domain\Model\User\UserId;
use Kreta\TaskManager\Domain\Model\User\UserRepository;

final class InMemoryUserRepository implements UserRepository
{
    private $users;
    private $eventBus;

    public function __construct(UserEventBus $anEventBus = null)
    {
        $this->users = [];
        $this->eventBus = $anEventBus;
    }

    public function userOfId(UserId $id)
    {
        if (isset($this->users[$id->id()])) {
            return $this->users[$id->id()];
        }
    }

    public function persist(User $user)
    {
        $this->users[$user->id()->id()] = $user;

        if ($this->eventBus instanceof UserEventBus) {
            $this->handle($user->events());
        }
    }

    private function handle($events)
    {
        foreach ($events as $event) {
            $this->eventBus->handle($event);
        }
    }
}
