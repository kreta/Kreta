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

abstract class Participant
{
    protected $id;
    protected $createdOn;
    protected $email;
    protected $username;
    protected $updatedOn;

    public function __construct(ParticipantId $id, ParticipantEmail $email, ParticipantUsername $username)
    {
        $this->id = $id;
        $this->email = $email;
        $this->username = $username;
        $this->createdOn = new \DateTimeImmutable();
        $this->updatedOn = new \DateTimeImmutable();
    }

    public function id() : ParticipantId
    {
        return $this->id;
    }

    public function changeEmail(ParticipantEmail $email)
    {
        $this->email = $email;
        $this->updatedOn = new \DateTimeImmutable();
    }

    public function changeUsername(ParticipantUsername $username)
    {
        $this->username = $username;
        $this->updatedOn = new \DateTimeImmutable();
    }

    public function createdOn() : \DateTimeInterface
    {
        return $this->createdOn;
    }

    public function email() : ParticipantEmail
    {
        return $this->email;
    }

    public function updatedOn() : \DateTimeInterface
    {
        return $this->updatedOn;
    }

    public function username() : ParticipantUsername
    {
        return $this->username;
    }

    public function __toString()
    {
        return (string) $this->id->id();
    }
}
