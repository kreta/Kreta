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

namespace Kreta\TaskManager\Domain\Model\User;

use Kreta\SharedKernel\Domain\Model\AggregateRoot;
use Kreta\SharedKernel\Domain\Model\Identity\Username;
use Symfony\Component\Validator\Constraints\Email;

class User extends AggregateRoot
{
    private $id;
    private $email;
    private $username;

    public function __construct(UserId $id, Email $email, Username $username)
    {
        $this->id = $id;
        $this->email = $email;
        $this->username = $username;
    }

    public function id() : UserId
    {
        return $this->id;
    }

    public function email() : Email
    {
        return $this->email;
    }

    public function username() : Username
    {
        return $this->username;
    }

    public function __toString() : string
    {
        return (string) $this->id->id();
    }
}
