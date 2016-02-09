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

namespace Kreta\Component\Organization\Model\Interfaces;

use Kreta\Component\User\Model\Interfaces\UserInterface;

/**
 * Organization participant interface.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 */
interface ParticipantInterface
{
    const ORG_ADMIN = 'ROLE_ORG_ADMIN';
    const ORG_PARTICIPANT = 'ROLE_ORG_PARTICIPANT';

    /**
     * Gets organization.
     *
     * @return OrganizationInterface
     */
    public function getOrganization();

    /**
     * Sets project.
     *
     * @param OrganizationInterface $organization The organization
     *
     * @return $this self Object
     */
    public function setOrganization(OrganizationInterface $organization);

    /**
     * Gets role.
     *
     * @return string
     */
    public function getRole();

    /**
     * Sets role.
     *
     * @param string $role The role
     *
     * @return $this self Object
     */
    public function setRole($role);

    /**
     * Gets user.
     *
     * @return UserInterface
     */
    public function getUser();

    /**
     * Sets user.
     *
     * @param UserInterface|null $user The user
     *
     * @return $this self Object
     */
    public function setUser(UserInterface $user = null);
}
