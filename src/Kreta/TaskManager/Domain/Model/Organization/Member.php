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

namespace Kreta\TaskManager\Domain\Model\Organization;

class Member
{
    protected $id;
    protected $createdOn;
    protected $updatedOn;

    public function __construct(MemberId $id)
    {
        $this->id = $id;
        $this->createdOn = new \DateTimeImmutable();
        $this->updatedOn = new \DateTimeImmutable();
    }

    public function id() : MemberId
    {
        return $this->id;
    }

    public function __toString() : string
    {
        return (string) $this->id->id();
    }
}
