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

namespace spec\Kreta\Component\Organization\Factory;

use Kreta\Component\Organization\Model\Interfaces\OrganizationInterface;
use Kreta\Component\User\Model\Interfaces\UserInterface;
use PhpSpec\ObjectBehavior;

/**
 * Spec file of ParticipantFactory class.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 */
class ParticipantFactorySpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('Kreta\Component\Organization\Model\Participant');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Component\Organization\Factory\ParticipantFactory');
    }

    function it_creates_a_participant(OrganizationInterface $project, UserInterface $user)
    {
        $this->create($project, $user)->shouldReturnAnInstanceOf('Kreta\Component\Organization\Model\Participant');
    }
}
