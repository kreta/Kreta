<?php

/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\Bundle\TimeTrackingBundle\Security\Authorization\Voter;

use Kreta\Component\Project\Model\Interfaces\ProjectInterface;
use Kreta\Component\TimeTracking\Model\TimeEntry;
use Kreta\Component\User\Model\Interfaces\UserInterface;
use Kreta\Component\Issue\Model\Issue;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

/**
 * Class TimeEntryVoterSpec.
 *
 * @package spec\Kreta\Bundle\TimeTrackingBundle\Security\Authorization\Voter
 */
class TimeEntryVoterSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Bundle\TimeTrackingBundle\Security\Authorization\Voter\TimeEntryVoter');
    }

    function it_extends_abstract_voter()
    {
        $this->shouldHaveType('Kreta\Bundle\CoreBundle\Security\Authorization\Voter\Abstracts\AbstractVoter');
    }

    function it_implements_voter_interface()
    {
        $this->shouldImplement('Symfony\Component\Security\Core\Authorization\Voter\VoterInterface');
    }

    function it_supports_attribute()
    {
        $this->supportsAttribute('create')->shouldReturn(true);
    }

    function it_does_not_support_attribute()
    {
        $this->supportsAttribute('non-exist-attribute')->shouldReturn(false);
    }

    function it_supports_class()
    {
        $this->supportsClass('Kreta\Component\TimeTracking\Model\Interfaces\TimeEntryInterface')->shouldReturn(true);
    }

    function it_does_not_support_class()
    {
        $this->supportsClass('Kreta\Component\Project\Model\Interfaces\ProjectInterface')->shouldReturn(false);
    }

    function it_does_not_vote_because_it_does_not_support_class(TokenInterface $token, ProjectInterface $project)
    {
        $this->vote($token, $project, [])->shouldReturn(0);
    }

    function it_does_not_vote_because_it_only_one_attribute_allowed(TokenInterface $token, TimeEntry $timeEntry)
    {
        $this->shouldThrow(new \InvalidArgumentException('Only one attribute allowed.'))
            ->during('vote', [$token, $timeEntry, []]);
    }

    function it_does_not_vote_because_it_does_not_support_attribute(TokenInterface $token, TimeEntry $timeEntry)
    {
        $this->vote($token, $timeEntry, ['non-exist-attribute'])->shouldReturn(0);
    }

    function it_does_not_vote_because_the_current_user_is_not_user_interface_instance(
        TokenInterface $token,
        TimeEntry $timeEntry
    )
    {
        $token->getUser()->shouldBeCalled()->willReturn(null);

        $this->vote($token, $timeEntry, ['create'])->shouldReturn(-1);
    }

    function it_does_not_vote_assign_or_edit_grant(
        TokenInterface $token,
        TimeEntry $timeEntry,
        Issue $issue,
        UserInterface $user,
        ProjectInterface $project
    )
    {
        $token->getUser()->shouldBeCalled()->willReturn($user);
        $timeEntry->getIssue()->shouldBeCalled()->willReturn($issue);
        $issue->getProject()->shouldBeCalled()->willReturn($project);
        $project->getUserRole($user)->shouldBeCalled()->willReturn('ROLE_PARTICIPANT');
        $issue->isAssignee($user)->shouldBeCalled()->willReturn(false);
        $issue->isReporter($user)->shouldBeCalled()->willReturn(false);

        $this->vote($token, $timeEntry, ['create'])->shouldReturn(-1);
    }

    function it_does_not_vote_view_grant(TokenInterface $token, TimeEntry $timeEntry, Issue $issue, UserInterface $user)
    {
        $token->getUser()->shouldBeCalled()->willReturn($user);
        $timeEntry->getIssue()->shouldBeCalled()->willReturn($issue);
        $issue->isParticipant($user)->shouldBeCalled()->willReturn(false);

        $this->vote($token, $timeEntry, ['view'])->shouldReturn(-1);
    }

    function it_votes_assign_or_edit_grant_because_its_role_project_is_admin(
        TokenInterface $token,
        TimeEntry $timeEntry,
        Issue $issue,
        UserInterface $user,
        ProjectInterface $project
    )
    {
        $token->getUser()->shouldBeCalled()->willReturn($user);
        $timeEntry->getIssue()->shouldBeCalled()->willReturn($issue);
        $issue->getProject()->shouldBeCalled()->willReturn($project);
        $project->getUserRole($user)->shouldBeCalled()->willReturn('ROLE_ADMIN');
        $issue->isAssignee($user)->shouldBeCalled()->willReturn(false);
        $issue->isReporter($user)->shouldBeCalled()->willReturn(false);

        $this->vote($token, $timeEntry, ['create'])->shouldReturn(1);
    }

    function it_votes_assign_or_edit_grant_because_it_is_reporter(
        TokenInterface $token,
        TimeEntry $timeEntry,
        Issue $issue,
        UserInterface $user,
        ProjectInterface $project
    )
    {
        $token->getUser()->shouldBeCalled()->willReturn($user);
        $timeEntry->getIssue()->shouldBeCalled()->willReturn($issue);
        $issue->getProject()->shouldBeCalled()->willReturn($project);
        $project->getUserRole($user)->shouldBeCalled()->willReturn('ROLE_PARTICIPANT');
        $issue->isAssignee($user)->shouldBeCalled()->willReturn(false);
        $issue->isReporter($user)->shouldBeCalled()->willReturn(true);

        $this->vote($token, $timeEntry, ['create'])->shouldReturn(1);
    }

    function it_votes_assign_or_edit_grant_because_it_is_assignee(
        TokenInterface $token,
        TimeEntry $timeEntry,
        Issue $issue,
        UserInterface $user,
        ProjectInterface $project
    )
    {
        $token->getUser()->shouldBeCalled()->willReturn($user);
        $timeEntry->getIssue()->shouldBeCalled()->willReturn($issue);
        $issue->getProject()->shouldBeCalled()->willReturn($project);
        $project->getUserRole($user)->shouldBeCalled()->willReturn('ROLE_PARTICIPANT');
        $issue->isAssignee($user)->shouldBeCalled()->willReturn(true);

        $this->vote($token, $timeEntry, ['create'])->shouldReturn(1);
    }

    function it_votes_view_grant(TokenInterface $token, TimeEntry $timeEntry, Issue $issue, UserInterface $user)
    {
        $token->getUser()->shouldBeCalled()->willReturn($user);
        $timeEntry->getIssue()->shouldBeCalled()->willReturn($issue);
        $issue->isParticipant($user)->shouldBeCalled()->willReturn(true);

        $this->vote($token, $timeEntry, ['view'])->shouldReturn(1);
    }
}
