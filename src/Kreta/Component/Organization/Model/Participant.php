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

namespace Kreta\Component\Organization\Model;

use Kreta\Component\Organization\Model\Interfaces\OrganizationInterface;
use Kreta\Component\Organization\Model\Interfaces\ParticipantInterface;
use Kreta\Component\User\Model\Interfaces\UserInterface;

/**
 * Organization Role class.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 */
class Participant implements ParticipantInterface
{
    /**
     * The organization.
     *
     * @var OrganizationInterface
     */
    protected $organization;

    /**
     * The role.
     *
     * @var string
     */
    protected $role;

    /**
     * The user.
     *
     * @var UserInterface
     */
    protected $user;

    /**
     * Constructor.
     *
     * @param OrganizationInterface $organization The organization
     * @param UserInterface         $user         The user
     */
    public function __construct(OrganizationInterface $organization, UserInterface $user)
    {
        $this->organization = $organization;
        $this->user = $user;
    }

    /**
     * {@inheritdoc}
     */
    public function getOrganization()
    {
        return $this->organization;
    }

    /**
     * {@inheritdoc}
     */
    public function setOrganization(OrganizationInterface $organization)
    {
        $this->organization = $organization;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * {@inheritdoc}
     */
    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * {@inheritdoc}
     */
    public function setUser(UserInterface $user = null)
    {
        $this->user = $user;

        return $this;
    }
}
