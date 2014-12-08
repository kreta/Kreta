<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\Component\Core\Factory;

use Kreta\Component\Core\Factory\ParticipantFactory;
use Kreta\Component\Core\Model\Interfaces\UserInterface;
use Kreta\Component\Core\Model\Participant;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Class ProjectFactorySpec.
 *
 * @package spec\Kreta\Component\Core\Factory
 */
class ProjectFactorySpec extends ObjectBehavior
{
    function let(ParticipantFactory $participantFactory)
    {
        $this->beConstructedWith('Kreta\Component\Core\Model\Project', $participantFactory);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Component\Core\Factory\ProjectFactory');
    }

    function it_creates_a_project(UserInterface $user, ParticipantFactory $participantFactory, Participant $participant)
    {
        $participantFactory->create(Argument::type('Kreta\Component\Core\Model\Project'), $user, 'ROLE_ADMIN')
            ->shouldBeCalled()->willReturn($participant);
        $this->create($user)->shouldReturnAnInstanceOf('Kreta\Component\Core\Model\Project');
    }
}
