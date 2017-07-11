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

namespace Kreta\SharedKernel\Infrastructure\Symfony\Security;

use Symfony\Component\Security\Core\User\UserInterface;

class User implements UserInterface
{
    private $userId;

    public function __construct(string $userId)
    {
        $this->userId = $userId;
    }

    public function getUsername() : string
    {
        return $this->userId;
    }

    public function getRoles()
    {
    }

    public function getPassword()
    {
    }

    public function getSalt()
    {
    }

    public function eraseCredentials()
    {
    }
}
