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

use Kreta\TaskManager\Domain\Model\User\UserId;

abstract class Member
{
    protected $id;
    protected $createdOn;
    protected $updatedOn;
    protected $userId;
    protected $organization;

    public function __construct(MemberId $id, UserId $userId, Organization $organization)
    {
        $this->id = $id;
        $this->userId = $userId;
        $this->organization = $organization;
        $this->createdOn = new \DateTimeImmutable();
        $this->updatedOn = new \DateTimeImmutable();
    }

    public function id() : MemberId
    {
        return $this->id;
    }

    public function createdOn() : \DateTimeInterface
    {
        return $this->createdOn;
    }

    public function organization() : Organization
    {
        return $this->organization;
    }

    public function updatedOn() : \DateTimeInterface
    {
        return $this->updatedOn;
    }

    public function userId() : UserId
    {
        return $this->userId;
    }

    public function __toString() : string
    {
        return (string) $this->id->id();
    }
}
