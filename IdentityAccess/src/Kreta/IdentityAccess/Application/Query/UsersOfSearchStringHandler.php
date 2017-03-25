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

namespace Kreta\IdentityAccess\Application\Query;

use BenGorUser\User\Application\DataTransformer\UserDataTransformer;
use BenGorUser\User\Domain\Model\UserId;
use Kreta\IdentityAccess\Domain\Model\User\User;
use Kreta\IdentityAccess\Domain\Model\User\UserRepository;

class UsersOfSearchStringHandler
{
    private $repository;
    private $dataTransformer;

    public function __construct(UserRepository $repository, UserDataTransformer $dataTransformer)
    {
        $this->repository = $repository;
        $this->dataTransformer = $dataTransformer;
    }

    public function __invoke(UsersOfSearchStringQuery $query)
    {
        $search = $query->search();
        $excludedIds = $query->excludedIds();

        $users = $this->repository->usersOfSearchString($search, $excludedIds);

        return array_map(function (User $user) {
            $this->dataTransformer->write($user);

            return $this->dataTransformer->read();
        }, $users);
    }
}
