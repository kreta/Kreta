<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\Component\Issue\Model;

use Kreta\Component\Comment\Model\Interfaces\CommentInterface;
use Kreta\Component\Issue\Model\Interfaces\LabelInterface;
use Kreta\Component\Project\Model\Interfaces\ProjectInterface;
use Kreta\Component\Issue\Model\Interfaces\ResolutionInterface;
use Kreta\Component\Workflow\Model\Interfaces\StatusInterface;
use Kreta\Component\User\Model\Interfaces\UserInterface;
use Kreta\Component\Project\Model\Participant;
use Kreta\Component\Project\Model\Project;
use Kreta\Component\User\Model\User;
use Kreta\Component\Workflow\Model\Interfaces\WorkflowInterface;
use PhpSpec\ObjectBehavior;

/**
 * Class IssueSpec.
 *
 * @package spec\Kreta\Component\Issue\Model
 */
class IssueSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Component\Issue\Model\Issue');
    }

    function it_extends_abstract_model()
    {
        $this->shouldHaveType('Kreta\Component\Core\Model\Abstracts\AbstractModel');
    }

    function it_implements_issue_interface()
    {
        $this->shouldImplement('Kreta\Component\Issue\Model\Interfaces\IssueInterface');
    }

    function its_comments_labels_and_watchers_are_collections()
    {
        $this->getComments()->shouldHaveType('Doctrine\Common\Collections\ArrayCollection');
        $this->getLabels()->shouldHaveType('Doctrine\Common\Collections\ArrayCollection');
        $this->getWatchers()->shouldHaveType('Doctrine\Common\Collections\ArrayCollection');
    }

    function its_created_at_is_a_datetime()
    {
        $this->getCreatedAt()->shouldHaveType('DateTime');
    }

    function its_assignee_be_mutable(UserInterface $assignee)
    {
        $this->setAssignee($assignee)->shouldReturn($this);
        $this->getAssignee()->shouldReturn($assignee);
    }

    function it_is_not_assignee(UserInterface $assignee, UserInterface $user)
    {
        $this->setAssignee($assignee)->shouldReturn($this);
        $assignee->getId()->shouldBeCalled()->willReturn('assignee-id');
        $user->getId()->shouldBeCalled()->willReturn('user-id');
        $this->isAssignee($user)->shouldReturn(false);
    }

    function it_is_assignee(UserInterface $assignee)
    {
        $this->setAssignee($assignee)->shouldReturn($this);
        $assignee->getId()->shouldBeCalled()->willReturn('user-id');
        $this->isAssignee($assignee)->shouldReturn(true);
    }

    function its_created_at_is_mutable()
    {
        $createDate = new \DateTime();

        $this->setCreatedAt($createDate)->shouldReturn($this);
        $this->getCreatedAt()->shouldReturn($createDate);
    }

    function its_comments_are_mutable(CommentInterface $comment)
    {
        $this->getComments()->shouldHaveCount(0);

        $this->addComment($comment);

        $this->getComments()->shouldHaveCount(1);

        $this->removeComment($comment);

        $this->getComments()->shouldHaveCount(0);
    }

    function its_description_is_mutable()
    {
        $this->setDescription('This is a dummy description of issue')->shouldReturn($this);
        $this->getDescription()->shouldReturn('This is a dummy description of issue');
    }

    function its_finite_state_is_mutable(
        ProjectInterface $project,
        WorkflowInterface $workflow,
        StatusInterface $status
    )
    {
        $status->getName()->shouldBeCalled()->willReturn('Done');
        $project->getWorkflow()->shouldBeCalled()->willReturn($workflow);
        $workflow->getStatuses()->shouldBeCalled()->willReturn([$status]);
        $this->setProject($project);

        $this->setFiniteState('Done')->shouldReturn($this);
        $this->getFiniteState()->shouldReturn('Done');
    }

    function its_labels_are_mutable(LabelInterface $label)
    {
        $this->getLabels()->shouldHaveCount(0);

        $this->addLabel($label);

        $this->getlabels()->shouldHaveCount(1);

        $this->removeLabel($label);

        $this->getLabels()->shouldHaveCount(0);
    }

    function its_numeric_id_is_mutable()
    {
        $this->setNumericId(1)->shouldReturn($this);
        $this->getNumericId()->shouldReturn(1);
    }

    function its_priority_is_mutable()
    {
        $this->setPriority(0)->shouldReturn($this);
        $this->getPriority()->shouldReturn(0);
    }

    function its_project_is_mutable(ProjectInterface $project)
    {
        $this->setProject($project)->shouldReturn($this);
        $this->getProject()->shouldReturn($project);
    }

    function its_resolution_is_mutable(ResolutionInterface $resolution)
    {
        $this->setResolution($resolution)->shouldReturn($this);
        $this->getResolution()->shouldReturn($resolution);
    }

    function its_reporter_is_mutable(UserInterface $reporter)
    {
        $this->setReporter($reporter)->shouldReturn($this);
        $this->getReporter()->shouldReturn($reporter);
    }

    function it_is_not_reporter(UserInterface $reporter, UserInterface $user)
    {
        $this->setReporter($reporter)->shouldReturn($this);
        $reporter->getId()->shouldBeCalled()->willReturn('reporter-id');
        $user->getId()->shouldBeCalled()->willReturn('user-id');
        $this->isReporter($user)->shouldReturn(false);
    }

    function it_is_reporter(UserInterface $reporter)
    {
        $this->setReporter($reporter)->shouldReturn($this);
        $reporter->getId()->shouldBeCalled()->willReturn('user-id');
        $this->isReporter($reporter)->shouldReturn(true);
    }

    function its_status_is_mutable(StatusInterface $status)
    {
        $this->setStatus($status)->shouldReturn($this);
        $this->getStatus()->shouldReturn($status);
    }

    function its_title_is_mutable()
    {
        $this->setTitle('Dummy title')->shouldReturn($this);
        $this->getTitle()->shouldReturn('Dummy title');
    }

    function its_type_is_mutable()
    {
        $this->setType(0)->shouldReturn($this);
        $this->getType()->shouldReturn(0);
    }

    function its_watchers_are_mutable(UserInterface $watcher)
    {
        $this->getWatchers()->shouldHaveCount(0);

        $this->addWatcher($watcher);

        $this->getWatchers()->shouldHaveCount(1);

        $this->removeWatcher($watcher);

        $this->getLabels()->shouldHaveCount(0);
    }

    function it_is_not_participant(UserInterface $anotherUser)
    {
        $project = new Project();
        $user = new User();
        $participant = new Participant($project, $user);
        $project->addParticipant($participant);

        $this->setProject($project)->shouldReturn($this);
        $anotherUser->getId()->shouldBeCalled()->willReturn('user-id');

        $this->isParticipant($anotherUser)->shouldReturn(false);
    }

    function it_is_participant(UserInterface $anotherUser)
    {
        $project = new Project();
        $user = new User();
        $participant = new Participant($project, $user);
        $project->addParticipant($participant);

        $this->setProject($project)->shouldReturn($this);

        $this->isParticipant($anotherUser)->shouldReturn(true);
    }

    function it_generates_numeric_id()
    {
        $project = new Project();
        $this->setProject($project);

        $this->getNumericId()->shouldReturn(null);

        $this->generateNumericId();

        $this->getNumericId()->shouldReturn(1);
    }
}
