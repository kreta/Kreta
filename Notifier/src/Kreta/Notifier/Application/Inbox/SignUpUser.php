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

namespace Kreta\Notifier\Application\Inbox;

use Kreta\Notifier\Domain\Model\Inbox\User;
use Kreta\Notifier\Domain\Model\Inbox\UserAlreadyExists;
use Kreta\Notifier\Domain\Model\Inbox\UserDoesNotExist;
use Kreta\Notifier\Domain\Model\Inbox\UserId;
use Kreta\Notifier\Domain\Model\Inbox\UserRepository;

class SignUpUser
{
    private $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(SignUpUserCommand $command)
    {
        $userId = UserId::generate($command->userId());

        $this->checkUserExists($userId);

        $user = User::signUp($userId);
        $this->repository->save($user);
    }

    private function checkUserExists(UserId $userId) : void
    {
        try {
            $user = $this->repository->get($userId);
            if ($user instanceof User) {
                throw new UserAlreadyExists($user->id());
            }
        } catch (UserDoesNotExist $exception) {
        }
    }
}
