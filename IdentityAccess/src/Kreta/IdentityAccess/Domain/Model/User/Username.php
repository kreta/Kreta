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

use BenGorUser\User\Domain\Model\UserEmail;

class Username
{
    const MAX_LENGTH = 20;
    const MIN_LENGTH = 3;

    private $username;

    public static function fromEmail(UserEmail $email)
    {
        $localPart = $email->localPart();
        $localPart = mb_substr($localPart, 0, self::MAX_LENGTH);

        $username = sprintf('%s%d', $localPart, mt_rand(1111, 9999));

        return new self($username);
    }

    public function __construct(string $username)
    {
        $this->setUsername($username);
    }

    private function setUsername(string $username)
    {
        $this->checkIsValidUsername($username);
        $this->username = $username;
    }

    private function checkIsValidUsername(string $username)
    {
        $regex = sprintf('/^[a-z0-9_.-]{%d,%d}$/', self::MIN_LENGTH, self::MAX_LENGTH);

        if (!preg_match($regex, $username)) {
            throw new UsernameInvalidException($username);
        }
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
