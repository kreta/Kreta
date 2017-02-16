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

class FullName
{
    private $firstName;
    private $lastName;

    public function __construct(string $firstName, string $lastName)
    {
        $this->setFirstName($firstName);
        $this->setLastName($lastName);
    }

    private function setFirstName(string $firstName)
    {
        $this->checkEmptyFirstName($firstName);
        $this->firstName = $firstName;
    }

    private function checkEmptyFirstName(string $firstName)
    {
        if ('' === $firstName) {
            throw new FirstNameEmptyException();
        }
    }

    private function setLastName(string $lastName)
    {
        $this->lastName = $lastName;
    }

    public function firstName() : string
    {
        // This ternary is a hack that avoids the
        // DoctrineORM limitation with nullable embeddables
        return null === $this->firstName ? '' : $this->firstName;
    }

    public function lastName() : string
    {
        // This ternary is a hack that avoids the
        // DoctrineORM limitation with nullable embeddables
        return null === $this->lastName ? '' : $this->lastName;
    }

    public function fullName() : string
    {
        if (!$this->lastName()) {
            return $this->firstName();
        }

        return $this->firstName() . ' ' . $this->lastName();
    }

    public function __toString() : string
    {
        return (string) $this->fullName();
    }
}
