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

namespace Kreta\IdentityAccess\Application\Command;

class EditProfileCommand
{
    private $id;
    private $email;
    private $username;
    private $firstName;
    private $lastName;

    public function __construct(string $id, string $email, string $username, string $firsName, string $lastName)
    {
        $this->id = $id;
        $this->email = $email;
        $this->username = $username;
        $this->firstName = $firsName;
        $this->lastName = $lastName;
    }

    public function id() : string
    {
        return $this->id;
    }

    public function email() : string
    {
        return $this->email;
    }

    public function username() : string
    {
        return $this->username;
    }

    public function firstName() : string
    {
        return $this->firstName;
    }

    public function lastName() : string
    {
        return $this->lastName;
    }
}
