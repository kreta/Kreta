<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\Component\Core\Model;

use Kreta\Component\Core\Model\Interfaces\IssueInterface;
use Kreta\Component\Core\Model\Interfaces\MediaInterface;
use Kreta\Component\Core\Model\Interfaces\ParticipantInterface;
use Kreta\Component\Core\Model\Interfaces\StatusInterface;
use Kreta\Component\Core\Model\Interfaces\StatusTransitionInterface;
use Kreta\Component\Core\Model\Interfaces\UserInterface;
use Kreta\Component\Core\Model\Participant;
use Kreta\Component\Core\Model\Project;
use Kreta\Component\Core\Model\User;
use PhpSpec\ObjectBehavior;

/**
 * Class ProjectSpec.
 *
 * @package spec\Kreta\Component\Core\Model
 */
class ProjectSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Component\Core\Model\Project');
    }

    function it_extends_abstract_model()
    {
        $this->shouldHaveType('Kreta\Component\Core\Model\Abstracts\AbstractModel');
    }

    function it_implements_project_interface()
    {
        $this->shouldImplement('Kreta\Component\Core\Model\Interfaces\ProjectInterface');
    }

    function its_issues_participants_project_roles_and_status_are_collection()
    {
        $this->getIssues()->shouldHaveType('Doctrine\Common\Collections\ArrayCollection');
        $this->getParticipants()->shouldHaveType('Doctrine\Common\Collections\ArrayCollection');
        $this->getStatuses()->shouldHaveType('Doctrine\Common\Collections\ArrayCollection');
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

    function its_short_name_is_mutable()
    {
        $this->setShortName('Dummy short name that it is a test for the PHPSpec')->shouldReturn($this);
        $this->getShortName()->shouldReturn('Dummy short name that it i...');

        $this->setShortName('Dummy short name')->shouldReturn($this);
        $this->getShortName()->shouldReturn('Dummy short name');
    }

    function its_statuses_are_be_mutable(StatusInterface $status)
    {
        $this->getStatuses()->shouldHaveCount(0);

        $this->addStatus($status);

        $this->getStatuses()->shouldHaveCount(1);

        $this->removeStatus($status);

        $this->getStatuses()->shouldHaveCount(0);
    }

    function its_status_transitions_are_be_mutable(StatusTransitionInterface $transition)
    {
        $this->getStatusTransitions()->shouldHaveCount(0);

        $this->addStatusTransition($transition);

        $this->getStatusTransitions()->shouldHaveCount(1);

        $this->removeStatusTransition($transition);

        $this->getStatusTransitions()->shouldHaveCount(0);
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
}
