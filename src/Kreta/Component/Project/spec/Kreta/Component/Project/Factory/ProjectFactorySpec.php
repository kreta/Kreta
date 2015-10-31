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

namespace spec\Kreta\Component\Project\Factory;

use Kreta\Component\Media\Factory\MediaFactory;
use Kreta\Component\Media\Model\Interfaces\MediaInterface;
use Kreta\Component\Media\Uploader\Interfaces\MediaUploaderInterface;
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
    function let(
        ParticipantFactory $participantFactory,
        WorkflowFactory $workflowFactory,
        MediaFactory $mediaFactory,
        MediaUploaderInterface $uploader
    )
    {
        $this->beConstructedWith(
            'Kreta\Component\Project\Model\Project', $participantFactory, $workflowFactory, $mediaFactory, $uploader
        );
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Component\Project\Factory\ProjectFactory');
    }

    function it_creates_a_project_with_workflow_but_without_projects_defaults(
        UserInterface $user,
        ParticipantFactory $participantFactory,
        ParticipantInterface $participant,
        WorkflowInterface $workflow,
        MediaFactory $mediaFactory,
        MediaInterface $image,
        MediaUploaderInterface $uploader
    )
    {
        $participantFactory->create(Argument::type('Kreta\Component\Project\Model\Project'), $user, 'ROLE_ADMIN')
            ->shouldBeCalled()->willReturn($participant);

        $mediaFactory->create(Argument::type('Symfony\Component\HttpFoundation\File\UploadedFile'))
            ->shouldBeCalled()->willReturn($image);
        $uploader->upload($image)->shouldBeCalled();

        $this->create($user, $workflow, false)->shouldReturnAnInstanceOf('Kreta\Component\Project\Model\Project');
    }

    function it_creates_a_project_without_workflow_but_with_projects_defaults(
        UserInterface $user,
        ParticipantFactory $participantFactory,
        ParticipantInterface $participant,
        WorkflowFactory $workflowFactory,
        WorkflowInterface $workflow,
        MediaFactory $mediaFactory,
        MediaInterface $image,
        MediaUploaderInterface $uploader
    )
    {
        $participantFactory->create(Argument::type('Kreta\Component\Project\Model\Project'), $user, 'ROLE_ADMIN')
            ->shouldBeCalled()->willReturn($participant);
        $workflowFactory->create('Default KRETA workflow', $user, true)
            ->shouldBeCalled()->willReturn($workflow);

        $mediaFactory->create(Argument::type('Symfony\Component\HttpFoundation\File\UploadedFile'))
            ->shouldBeCalled()->willReturn($image);
        $uploader->upload($image)->shouldBeCalled();

        $this->create($user, null, true)->shouldReturnAnInstanceOf('Kreta\Component\Project\Model\Project');
    }

    function it_creates_a_project_passing_the_image(
        UserInterface $user,
        ParticipantFactory $participantFactory,
        ParticipantInterface $participant,
        WorkflowInterface $workflow,
        MediaInterface $image,
        MediaUploaderInterface $uploader
    )
    {
        $participantFactory->create(Argument::type('Kreta\Component\Project\Model\Project'), $user, 'ROLE_ADMIN')
            ->shouldBeCalled()->willReturn($participant);

        $uploader->upload($image)->shouldBeCalled();

        $this->create($user, $workflow, false, $image)->shouldReturnAnInstanceOf(
            'Kreta\Component\Project\Model\Project'
        );
    }
}
