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

class Organization
{
    private $id;
    private $name;
    private $slug;
    private $owners;
    private $participants;

    public function __construct(OrganizationId $id, OrganizationName $name, OrganizationSlug $slug, Owner $creator)
    {
        $this->id = $id;
        $this->name = $name;
        $this->slug = $slug;
        $this->owners = new OwnerCollection();
        $this->participants = new ParticipantCollection();
        $this->addOwner($creator);
    }

    public function id() : OrganizationId
    {
        return $this->id;
    }

    public function name() : OrganizationName
    {
        return $this->name;
    }

    public function slug() : OrganizationSlug
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

    public function participants() : ParticipantCollection
    {
        return $this->participants;
    }

    public function addParticipant(OrganizationParticipant $participant)
    {
        $this->participants->add($participant);
    }

    public function removeParticipant(OrganizationParticipant $participant)
    {
        $this->participants->remove($participant);
    }

    public function __toString() : string
    {
        return (string)$this->id->id();
    }
}
