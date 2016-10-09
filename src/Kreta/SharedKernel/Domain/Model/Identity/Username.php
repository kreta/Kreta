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

namespace Kreta\SharedKernel\Domain\Model\Identity;

class Username
{
    protected $username;

    public function __construct(string $username)
    {
        if ('' === $username) {
            throw new UsernameInvalidException();
        }
        $this->username = $username;
    }

    public function username() : string
    {
        return $this->username;
    }

    public function __toString() : string
    {
        return (string) $this->username;
    }
}
