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

use Kreta\SharedKernel\Domain\Model\AggregateRoot;
use Kreta\SharedKernel\Domain\Model\Identity\Slug;
use Kreta\TaskManager\Domain\Model\User\UserId;

class Organization extends AggregateRoot
{
    private $id;
    private $createdOn;
    private $members;
    private $name;
    private $owners;
    private $slug;
    private $updatedOn;

    public function __construct(OrganizationId $id, OrganizationName $name, Slug $slug, UserId $userId)
    {
        $this->id = $id;
        $this->name = $name;
        $this->slug = $slug;
        $this->members = new MemberCollection();
        $this->owners = new OwnerCollection();
        $this->createdOn = new \DateTimeImmutable();
        $this->updatedOn = new \DateTimeImmutable();
        $this->addOwner($userId);

        $this->publish(
            new OrganizationCreated($id, $name, $slug)
        );
    }

    public function addMember(UserId $userId)
    {
        if ($this->isOwner($userId)) {
            throw new MemberIsAlreadyAnOwnerException($userId);
        }
        $member = new Member(MemberId::generate(), $userId, $this);
        $this->members->add($member);
        $this->updatedOn = new \DateTimeImmutable();
        $this->publish(
            new MemberAdded($member->id(), $member->userId(), $this->id)
        );
    }

    public function addOwner(UserId $userId)
    {
        if (!$this->isOwner($userId) && $this->isMember($userId)) {
            $this->removeMember($userId);
        }
        $owner = new Owner(OwnerId::generate(), $userId, $this);
        $this->owners->add($owner);
        $this->updatedOn = new \DateTimeImmutable();
        $this->publish(
            new OwnerAdded($owner->id(), $owner->userId(), $this->id)
        );
    }

    public function edit(OrganizationName $name, Slug $slug)
    {
        $this->name = $name;
        $this->slug = $slug;
        $this->updatedOn = new \DateTimeImmutable();
        $this->publish(
            new OrganizationEdited($this->id, $name, $slug)
        );
    }

    public function removeMember(UserId $userId)
    {
        foreach ($this->members as $member) {
            if ($userId->equals($member->userId())) {
                $this->members->remove($member);
                $this->updatedOn = new \DateTimeImmutable();

                $this->publish(new MemberRemoved($this->id, $member->id()));

                break;
            }
        }
    }

    public function removeOwner(UserId $userId)
    {
        if ($this->owners()->count() === 1) {
            throw new UnauthorizedRemoveOwnerException();
        }
        foreach ($this->owners as $owner) {
            if ($userId->equals($owner->userId())) {
                $this->owners->remove($owner);
                $this->updatedOn = new \DateTimeImmutable();

                $this->publish(new OwnerRemoved($this->id, $owner->id()));

                break;
            }
        }
    }

    public function isOwner(UserId $userId) : bool
    {
        return $this->owners->exists(
            function ($key, Owner $owner) use ($userId) {
                return $userId->equals($owner->userId());
            }
        );
    }

    public function isMember(UserId $userId) : bool
    {
        $isMember = $this->members->exists(
            function ($key, Member $member) use ($userId) {
                return $userId->equals($member->userId());
            }
        );

        return $isMember || $this->isOwner($userId);
    }

    public function id() : OrganizationId
    {
        return $this->id;
    }

    public function createdOn() : \DateTimeInterface
    {
        return $this->createdOn;
    }

    public function members() : MemberCollection
    {
        return $this->members;
    }

    public function member(UserId $userId)
    {
        foreach ($this->members() as $member) {
            if ($userId->equals($member->userId())) {
                return $member;
            }
        }

        return $this->owner($userId);
    }

    public function name() : OrganizationName
    {
        return $this->name;
    }

    public function owners() : OwnerCollection
    {
        return $this->owners;
    }

    public function owner(UserId $userId)
    {
        foreach ($this->owners as $owner) {
            if ($userId->equals($owner->userId())) {
                return $owner;
            }
        }
    }

    public function slug() : Slug
    {
        return $this->slug;
    }

    public function updatedOn() : \DateTimeInterface
    {
        return $this->updatedOn;
    }

    public function __toString() : string
    {
        return (string) $this->id->id();
    }
}
