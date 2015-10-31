<?php

/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\Component\Project\Model;

use Kreta\Component\Issue\Model\Interfaces\IssueInterface;
use Kreta\Component\Media\Model\Interfaces\MediaInterface;
use Kreta\Component\Project\Model\Interfaces\LabelInterface;
use Kreta\Component\Project\Model\Interfaces\ParticipantInterface;
use Kreta\Component\Project\Model\Interfaces\IssuePriorityInterface;
use Kreta\Component\User\Model\Interfaces\UserInterface;
use Kreta\Component\Project\Model\Participant;
use Kreta\Component\Project\Model\Project;
use Kreta\Component\User\Model\User;
use Kreta\Component\Workflow\Model\Interfaces\WorkflowInterface;
use PhpSpec\ObjectBehavior;

/**
 * Class ProjectSpec.
 *
 * @package spec\Kreta\Component\Project\Model
 */
class ProjectSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Component\Project\Model\Project');
    }

    function it_implements_project_interface()
    {
        $this->shouldImplement('Kreta\Component\Project\Model\Interfaces\ProjectInterface');
    }

    function its_issues_labels_participants_and_issue_priorities_are_collection()
    {
        $this->getIssues()->shouldHaveType('Doctrine\Common\Collections\ArrayCollection');
        $this->getLabels()->shouldHaveType('Doctrine\Common\Collections\ArrayCollection');
        $this->getParticipants()->shouldHaveType('Doctrine\Common\Collections\ArrayCollection');
        $this->getIssuePriorities()->shouldHaveType('Doctrine\Common\Collections\ArrayCollection');
    }

    function its_image_is_mutable(MediaInterface $media)
    {
        $this->setImage($media)->shouldReturn($this);
        $this->getImage()->shouldReturn($media);
    }

    function its_issues_are_mutable(IssueInterface $issue)
    {
        $this->getIssues()->shouldHaveCount(0);

        $this->addIssue($issue);

        $this->getIssues()->shouldHaveCount(1);

        $this->removeIssue($issue);

        $this->getIssues()->shouldHaveCount(0);
    }

    function its_labels_are_be_mutable(LabelInterface $label)
    {
        $this->getLabels()->shouldHaveCount(0);

        $this->addLabel($label);

        $this->getLabels()->shouldHaveCount(1);

        $this->removeLabel($label);

        $this->getLabels()->shouldHaveCount(0);
    }

    function its_name_is_mutable()
    {
        $this->setName('Dummy name that it is a test for the PHPSpec')->shouldReturn($this);
        $this->getName()->shouldReturn('Dummy name that it is a test for the PHPSpec');

        $this->getShortName()->shouldReturn('Dummy name that it is a te...');
    }

    function its_project_roles_are_be_mutable(ParticipantInterface $participant)
    {
        $this->getParticipants()->shouldHaveCount(0);

        $this->addParticipant($participant);

        $this->getParticipants()->shouldHaveCount(1);

        $this->removeParticipant($participant);

        $this->getParticipants()->shouldHaveCount(0);
    }

    function its_issue_priorities_are_be_mutable(IssuePriorityInterface $issuePriority)
    {
        $this->getIssuePriorities()->shouldHaveCount(0);

        $this->addIssuePriority($issuePriority);

        $this->getIssuePriorities()->shouldHaveCount(1);

        $this->removeIssuePriority($issuePriority);

        $this->getIssuePriorities()->shouldHaveCount(0);
    }

    function its_short_name_is_mutable()
    {
        $this->setShortName('Dummy short name that it is a test for the PHPSpec')->shouldReturn($this);
        $this->getShortName()->shouldReturn('Dummy short name that it i...');

        $this->setShortName('Dummy short name')->shouldReturn($this);
        $this->getShortName()->shouldReturn('Dummy short name');
    }

    function it_does_not_get_user_role(UserInterface $anotherUser)
    {
        $project = new Project();
        $user = new User();
        $participant = new Participant($project, $user);

        $this->addParticipant($participant)->shouldReturn($this);
        $anotherUser->getId()->shouldBeCalled()->willReturn('user-id');

        $this->getUserRole($anotherUser)->shouldReturn(null);
    }

    function it_gets_user_role(UserInterface $anotherUser)
    {
        $project = new Project();
        $user = new User();
        $participant = new Participant($project, $user);
        $participant->setRole('ROLE_ADMIN');

        $this->addParticipant($participant)->shouldReturn($this);

        $this->getUserRole($anotherUser)->shouldReturn('ROLE_ADMIN');
    }

    function its_workflow_is_mutable(WorkflowInterface $workflow)
    {
        $this->setWorkflow($workflow)->shouldReturn($this);
        $this->getWorkflow()->shouldReturn($workflow);
    }
}
