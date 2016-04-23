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
use Kreta\Component\Organization\Model\Interfaces\OrganizationInterface;
use Kreta\Component\Project\Factory\ParticipantFactory;
use Kreta\Component\Project\Model\Interfaces\ParticipantInterface;
use Kreta\Component\User\Model\Interfaces\UserInterface;
use Kreta\Component\Workflow\Factory\WorkflowFactory;
use Kreta\Component\Workflow\Model\Interfaces\WorkflowInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class ProjectFactorySpec.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
 */
class ProjectFactorySpec extends ObjectBehavior
{
    function let(
        ParticipantFactory $participantFactory,
        WorkflowFactory $workflowFactory,
        MediaFactory $mediaFactory,
        MediaUploaderInterface $uploader
    ) {
        $this->beConstructedWith(
            'Kreta\Component\Project\Model\Project', $participantFactory, $workflowFactory, $mediaFactory, $uploader
        );
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Component\Project\Factory\ProjectFactory');
    }

    function it_creates_a_project_without_organization_with_workflow_but_without_projects_defaults(
        UserInterface $user,
        ParticipantFactory $participantFactory,
        ParticipantInterface $participant,
        WorkflowInterface $workflow
    ) {
        $participantFactory->create(Argument::type('Kreta\Component\Project\Model\Project'), $user, 'ROLE_ADMIN')
            ->shouldBeCalled()->willReturn($participant);

        $this->create($user, null, $workflow, false)
            ->shouldReturnAnInstanceOf('Kreta\Component\Project\Model\Project');
    }

    function it_creates_a_project_with_workflow_but_without_projects_defaults(
        UserInterface $user,
        OrganizationInterface $organization,
        WorkflowInterface $workflow
    ) {
        $this->create($user, $organization, $workflow, false)
            ->shouldReturnAnInstanceOf('Kreta\Component\Project\Model\Project');
    }

    function it_creates_a_project_without_organization_and_without_workflow_but_with_projects_defaults(
        UserInterface $user,
        ParticipantFactory $participantFactory,
        ParticipantInterface $participant,
        WorkflowFactory $workflowFactory,
        WorkflowInterface $workflow
    ) {
        $participantFactory->create(
            Argument::type('Kreta\Component\Project\Model\Project'), $user, 'ROLE_ADMIN'
        )->shouldBeCalled()->willReturn($participant);
        $workflowFactory->create('Default KRETA workflow', $user, true)->shouldBeCalled()->willReturn($workflow);

        $this->create($user, null, null, true)->shouldReturnAnInstanceOf('Kreta\Component\Project\Model\Project');
    }

    function it_creates_a_project_passing_the_image(
        UserInterface $user,
        OrganizationInterface $organization,
        WorkflowInterface $workflow,
        MediaUploaderInterface $uploader,
        MediaFactory $mediaFactory,
        MediaInterface $media
    ) {
        $image = new UploadedFile('', '', null, null, 99, true); // Avoids file not found exception

        $mediaFactory->create($image)->shouldBeCalled()->willReturn($media);
        $uploader->upload($media)->shouldBeCalled();

        $this->create($user, $organization, $workflow, false, $image)->shouldReturnAnInstanceOf(
            'Kreta\Component\Project\Model\Project'
        );
    }
}
