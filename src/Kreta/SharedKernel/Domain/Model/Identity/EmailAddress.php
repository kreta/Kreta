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

class EmailAddress
{
    protected $email;
    protected $domain;
    protected $localPart;

    public function __construct($email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new EmailAddressInvalidException();
        }
        $this->email = $email;
        $this->localPart = implode(explode('@', $this->email, -1), '@');
        $this->domain = str_replace($this->localPart . '@', '', $this->email);
    }

    public function email() : string
    {
        return $this->email;
    }

    public function localPart() : string
    {
        return $this->localPart;
    }

    public function domain() : string
    {
        return $this->domain;
    }

    public function equals(EmailAddress $email) : bool
    {
        return strtolower((string) $this) === strtolower((string) $email);
    }

    public function __toString() : string
    {
        return (string) $this->email;
    }
}
