<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\Component\Project\Factory;

use Kreta\Component\Project\Factory\ParticipantFactory;
use Kreta\Component\Project\Model\Interfaces\ParticipantInterface;
use Kreta\Component\User\Model\Interfaces\UserInterface;
use Kreta\Component\Workflow\Factory\WorkflowFactory;
use Kreta\Component\Workflow\Model\Interfaces\WorkflowInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Class ProjectFactorySpec.
 *
 * @package spec\Kreta\Component\Project\Factory
 */
class ProjectFactorySpec extends ObjectBehavior
{
    function let(ParticipantFactory $participantFactory, WorkflowFactory $workflowFactory)
    {
        $this->beConstructedWith('Kreta\Component\Project\Model\Project', $participantFactory, $workflowFactory);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Component\Project\Factory\ProjectFactory');
    }

    function it_creates_a_project_with_workflow(
        UserInterface $user,
        ParticipantFactory $participantFactory,
        ParticipantInterface $participant,
        WorkflowInterface $workflow
    )
    {
        $participantFactory->create(Argument::type('Kreta\Component\Project\Model\Project'), $user, 'ROLE_ADMIN')
            ->shouldBeCalled()->willReturn($participant);

        $this->create($user, $workflow)->shouldReturnAnInstanceOf('Kreta\Component\Project\Model\Project');
    }

    function it_creates_a_project_without_workflow(
        UserInterface $user,
        ParticipantFactory $participantFactory,
        ParticipantInterface $participant,
        WorkflowFactory $workflowFactory,
        WorkflowInterface $workflow
    )
    {
        $participantFactory->create(Argument::type('Kreta\Component\Project\Model\Project'), $user, 'ROLE_ADMIN')
            ->shouldBeCalled()->willReturn($participant);
        $workflowFactory->create('Default KRETA workflow', $user, true)
            ->shouldBeCalled()->willReturn($workflow);

        $this->create($user, null)->shouldReturnAnInstanceOf('Kreta\Component\Project\Model\Project');
    }
}
