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

class Organization extends AggregateRoot
{
    private $id;
    private $name;
    private $slug;
    private $owners;
    private $participants;

    public function __construct(OrganizationId $id, OrganizationName $name, Slug $slug, Owner $creator)
    {
        $this->id = $id;
        $this->name = $name;
        $this->slug = $slug;
        $this->owners = new OwnerCollection();
        $this->participants = new MemberCollection();
        $this->addOwner($creator);

        $this->publish(
            new OrganizationCreated($id)
        );
    }

    public function id() : OrganizationId
    {
        return $this->id;
    }

    public function name() : OrganizationName
    {
        return $this->name;
    }

    public function slug() : Slug
    {
        return $this->slug;
    }

    public function owners() : OwnerCollection
    {
        return $this->owners;
    }

    public function addOwner(Owner $owner)
    {
        $this->owners->add($owner);
    }

    public function removeOwner(Owner $owner)
    {
        $this->owners->remove($owner);
    }

    public function participants() : MemberCollection
    {
        return $this->participants;
    }

    public function addMember(OrganizationMember $participant)
    {
        $this->participants->add($participant);
    }

    public function removeMember(OrganizationMember $participant)
    {
        $this->participants->remove($participant);
    }

    public function __toString() : string
    {
        return (string) $this->id->id();
    }
}
