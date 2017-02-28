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

namespace Kreta\IdentityAccess\Domain\Model\User;

use BenGorUser\User\Domain\Model\UserRepository as BaseUserRepository;

interface UserRepository extends BaseUserRepository
{
    public function userOfUsername(Username $username);

    public function usersOfIds(array $userIds) : array;

    public function usersOfSearchString($search) : array;
}
