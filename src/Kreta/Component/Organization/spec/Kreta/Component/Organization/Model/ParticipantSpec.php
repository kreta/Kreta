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

namespace spec\Kreta\Component\Organization\Model;

use Kreta\Component\Organization\Model\Interfaces\OrganizationInterface;
use Kreta\Component\User\Model\Interfaces\UserInterface;
use PhpSpec\ObjectBehavior;

/**
 * Spec file of Participant class.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 */
class ParticipantSpec extends ObjectBehavior
{
    function let(OrganizationInterface $organization, UserInterface $user)
    {
        $this->beConstructedWith($organization, $user);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Component\Organization\Model\Participant');
    }

    function it_implements_organization_role_interface()
    {
        $this->shouldImplement('Kreta\Component\Organization\Model\Interfaces\ParticipantInterface');
    }

    function its_organization_is_mutable(OrganizationInterface $organization)
    {
        $this->setOrganization($organization)->shouldReturn($this);
        $this->getOrganization()->shouldReturn($organization);
    }

    function its_role_is_mutable()
    {
        $this->setRole('ROLE_DUMMY')->shouldReturn($this);
        $this->getRole()->shouldReturn('ROLE_DUMMY');
    }

    function its_user_is_mutable(UserInterface $user)
    {
        $this->setUser($user)->shouldReturn($this);
        $this->getUser()->shouldReturn($user);
    }
}
