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
    private $organizationMembers;
    private $name;
    private $owners;
    private $slug;
    private $updatedOn;

    public function __construct(OrganizationId $id, OrganizationName $name, Slug $slug, UserId $userId)
    {
        $this->id = $id;
        $this->name = $name;
        $this->slug = $slug;
        $this->organizationMembers = new OrganizationMemberCollection();
        $this->owners = new OwnerCollection();
        $this->createdOn = new \DateTimeImmutable();
        $this->updatedOn = new \DateTimeImmutable();
        $this->addOwner($userId);

        $this->publish(
            new OrganizationCreated($id, $name, $slug)
        );
    }

    public function addOrganizationMember(UserId $userId)
    {
        if ($this->isOwner($userId)) {
            throw new OrganizationMemberIsAlreadyAnOwnerException($userId);
        }
        $organizationMembers = new OrganizationMember(OrganizationMemberId::generate(), $userId, $this);
        $this->organizationMembers->add($organizationMembers);
        $this->updatedOn = new \DateTimeImmutable();
        $this->publish(
            new OrganizationMemberAdded($organizationMembers->id(), $organizationMembers->userId(), $this->id)
        );
    }

    public function addOwner(UserId $userId)
    {
        if (!$this->isOwner($userId) && $this->isOrganizationMember($userId)) {
            $this->removeOrganizationMember($userId);
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

    public function removeOrganizationMember(UserId $userId)
    {
        foreach ($this->organizationMembers as $organizationMember) {
            if ($userId->equals($organizationMember->userId())) {
                $this->organizationMembers->remove($organizationMember);
                $this->updatedOn = new \DateTimeImmutable();

                $this->publish(new OrganizationMemberRemoved($this->id, $organizationMember->id()));

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

    public function isOrganizationMember(UserId $userId) : bool
    {
        $isOrganizationMember = $this->organizationMembers->exists(
            function ($key, OrganizationMember $organizationMember) use ($userId) {
                return $userId->equals($organizationMember->userId());
            }
        );

        return $isOrganizationMember || $this->isOwner($userId);
    }

    public function id() : OrganizationId
    {
        return $this->id;
    }

    public function createdOn() : \DateTimeInterface
    {
        return $this->createdOn;
    }

    public function organizationMembers()
    {
        return new OrganizationMemberCollection($this->organizationMembers->getValues());
    }

    public function organizationMember(UserId $userId)
    {
        foreach ($this->organizationMembers() as $member) {
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
        return new OwnerCollection($this->owners->getValues());
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
