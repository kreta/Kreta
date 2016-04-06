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

namespace spec\Kreta\Bundle\IssueBundle\Security\Authorization\Voter;

use Kreta\Component\Issue\Model\Issue;
use Kreta\Component\Project\Model\Interfaces\ProjectInterface;
use Kreta\Component\User\Model\Interfaces\UserInterface;
use PhpSpec\ObjectBehavior;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

/**
 * Class IssueVoterSpec.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
 */
class IssueVoterSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Bundle\IssueBundle\Security\Authorization\Voter\IssueVoter');
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
        $this->supportsAttribute('assign')->shouldReturn(true);
    }

    function it_does_not_support_attribute()
    {
        $this->supportsAttribute('non-exist-attribute')->shouldReturn(false);
    }

    function it_supports_class()
    {
        $this->supportsClass('Kreta\Component\Issue\Model\Interfaces\IssueInterface')->shouldReturn(true);
    }

    function it_does_not_support_class()
    {
        $this->supportsClass('Kreta\Component\Project\Model\Interfaces\ProjectInterface')->shouldReturn(false);
    }

    function it_does_not_vote_because_it_does_not_support_class(TokenInterface $token, ProjectInterface $project)
    {
        $this->vote($token, $project, [])->shouldReturn(0);
    }

    function it_does_not_vote_because_it_only_one_attribute_allowed(TokenInterface $token, Issue $issue)
    {
        $this->shouldThrow(new \InvalidArgumentException('Only one attribute allowed.'))
            ->during('vote', [$token, $issue, []]);
    }

    function it_does_not_vote_because_it_does_not_support_attribute(TokenInterface $token, Issue $issue)
    {
        $this->vote($token, $issue, ['non-exist-attribute'])->shouldReturn(0);
    }

    function it_does_not_vote_because_the_current_user_is_not_user_interface_instance(
        TokenInterface $token,
        Issue $issue
    ) {
        $token->getUser()->shouldBeCalled()->willReturn(null);

        $this->vote($token, $issue, ['assign'])->shouldReturn(-1);
    }

    function it_does_not_vote_assign_or_edit_grant(
        TokenInterface $token,
        Issue $issue,
        UserInterface $user,
        ProjectInterface $project
    ) {
        $token->getUser()->shouldBeCalled()->willReturn($user);
        $issue->getProject()->shouldBeCalled()->willReturn($project);
        $project->getUserRole($user)->shouldBeCalled()->willReturn('ROLE_PARTICIPANT');
        $issue->isAssignee($user)->shouldBeCalled()->willReturn(false);
        $issue->isReporter($user)->shouldBeCalled()->willReturn(false);

        $this->vote($token, $issue, ['assign'])->shouldReturn(-1);
    }

    function it_does_not_vote_view_grant(TokenInterface $token, Issue $issue, UserInterface $user)
    {
        $token->getUser()->shouldBeCalled()->willReturn($user);
        $issue->isParticipant($user)->shouldBeCalled()->willReturn(false);

        $this->vote($token, $issue, ['view'])->shouldReturn(-1);
    }

    function it_votes_assign_or_edit_grant_because_its_role_project_is_admin(
        TokenInterface $token,
        Issue $issue,
        UserInterface $user,
        ProjectInterface $project
    ) {
        $token->getUser()->shouldBeCalled()->willReturn($user);
        $issue->getProject()->shouldBeCalled()->willReturn($project);
        $project->getUserRole($user)->shouldBeCalled()->willReturn('ROLE_ADMIN');
        $issue->isAssignee($user)->shouldBeCalled()->willReturn(false);
        $issue->isReporter($user)->shouldBeCalled()->willReturn(false);

        $this->vote($token, $issue, ['assign'])->shouldReturn(1);
    }

    function it_votes_assign_or_edit_grant_because_it_is_reporter(
        TokenInterface $token,
        Issue $issue,
        UserInterface $user,
        ProjectInterface $project
    ) {
        $token->getUser()->shouldBeCalled()->willReturn($user);
        $issue->getProject()->shouldBeCalled()->willReturn($project);
        $project->getUserRole($user)->shouldBeCalled()->willReturn('ROLE_PARTICIPANT');
        $issue->isAssignee($user)->shouldBeCalled()->willReturn(false);
        $issue->isReporter($user)->shouldBeCalled()->willReturn(true);

        $this->vote($token, $issue, ['assign'])->shouldReturn(1);
    }

    function it_votes_assign_or_edit_grant_because_it_is_assignee(
        TokenInterface $token,
        Issue $issue,
        UserInterface $user,
        ProjectInterface $project
    ) {
        $token->getUser()->shouldBeCalled()->willReturn($user);
        $issue->getProject()->shouldBeCalled()->willReturn($project);
        $project->getUserRole($user)->shouldBeCalled()->willReturn('ROLE_PARTICIPANT');
        $issue->isAssignee($user)->shouldBeCalled()->willReturn(true);

        $this->vote($token, $issue, ['assign'])->shouldReturn(1);
    }

    function it_votes_view_grant(TokenInterface $token, Issue $issue, UserInterface $user)
    {
        $token->getUser()->shouldBeCalled()->willReturn($user);
        $issue->isParticipant($user)->shouldBeCalled()->willReturn(true);

        $this->vote($token, $issue, ['view'])->shouldReturn(1);
    }
}
