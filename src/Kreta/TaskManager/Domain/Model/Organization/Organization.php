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

declare(strict_types = 1);

namespace Kreta\TaskManager\Domain\Model\Organization;

use Kreta\SharedKernel\Domain\Model\AggregateRoot;
use Kreta\SharedKernel\Domain\Model\Identity\Slug;

class Organization extends AggregateRoot
{
    private $id;
    private $createdOn;
    private $members;
    private $name;
    private $owners;
    private $slug;
    private $updatedOn;

    public function __construct(OrganizationId $id, OrganizationName $name, Slug $slug, Owner $creator)
    {
        $this->id = $id;
        $this->name = $name;
        $this->slug = $slug;
        $this->members = new MemberCollection();
        $this->owners = new OwnerCollection();
        $this->createdOn = new \DateTimeImmutable();
        $this->updatedOn = new \DateTimeImmutable();
        $this->addOwner($creator);

        $this->publish(
            new OrganizationCreated($id, $name, $slug)
        );
    }

    public function addMember(Member $member)
    {
        if ($this->isOwner($member->id())) {
            throw new MemberIsAlreadyAnOwnerException($member->id());
        }
        $this->members->add($member);
        $this->updatedOn = new \DateTimeImmutable();
        $this->publish(
            new MemberAdded($this->id, $member->id())
        );
    }

    public function addOwner(Owner $owner)
    {
        if (!$this->isOwner($owner->id()) && $this->isMember($owner->id())) {
            $this->removeMember($owner);
        }
        $this->owners->add($owner);
        $this->updatedOn = new \DateTimeImmutable();
        $this->publish(
            new OwnerAdded($this->id, $owner->id())
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

    public function removeMember(Member $member)
    {
        $this->members->remove($member);
        $this->updatedOn = new \DateTimeImmutable();
        $this->publish(
            new MemberRemoved($this->id, $member->id())
        );
    }

    public function removeOwner(Owner $owner)
    {
        if ($this->owners()->count() === 1) {
            throw new UnauthorizedRemoveOwnerException();
        }
        $this->owners->remove($owner);
        $this->updatedOn = new \DateTimeImmutable();
        $this->publish(
            new OwnerRemoved($this->id, $owner->id())
        );
    }

    public function isOwner(MemberId $ownerId) : bool
    {
        return $this->owners->exists(
            function ($key, Owner $owner) use ($ownerId) {
                return $ownerId->equals($owner->id());
            }
        );
    }

    public function isMember(MemberId $memberId) : bool
    {
        $isMember = $this->members->exists(
            function ($key, Member $member) use ($memberId) {
                return $memberId->equals($member->id());
            }
        );

        return $isMember || $this->isOwner($memberId);
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
        return new MemberCollection($this->members()->getValues());
    }

    public function name() : OrganizationName
    {
        return $this->name;
    }

    public function owners() : OwnerCollection
    {
        return new OwnerCollection($this->owners->getValues());
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
        return (string)$this->id->id();
    }
}
