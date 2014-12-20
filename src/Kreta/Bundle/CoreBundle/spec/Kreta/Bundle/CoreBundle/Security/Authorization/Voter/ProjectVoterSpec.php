<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\Bundle\CoreBundle\Security\Authorization\Voter;

use Kreta\Component\Issue\Model\Interfaces\IssueInterface;
use Kreta\Component\Project\Model\Interfaces\ProjectInterface;
use Kreta\Component\User\Model\Interfaces\UserInterface;
use Kreta\Component\Project\Model\Project;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

/**
 * Class ProjectVoterSpec.
 *
 * @package spec\Kreta\Bundle\CoreBundle\Security\Authorization\Voter
 */
class ProjectVoterSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Bundle\CoreBundle\Security\Authorization\Voter\ProjectVoter');
    }

    function it_implements_voter_interface()
    {
        $this->shouldImplement('Symfony\Component\Security\Core\Authorization\Voter\VoterInterface');
    }

    function it_supports_attribute()
    {
        $this->supportsAttribute('add_participant')->shouldReturn(true);
    }

    function it_does_not_support_attribute()
    {
        $this->supportsAttribute('non-exist-attribute')->shouldReturn(false);
    }

    function it_supports_class()
    {
        $this->supportsClass('Kreta\Component\Project\Model\Interfaces\ProjectInterface')->shouldReturn(true);
    }

    function it_does_not_support_class()
    {
        $this->supportsClass('Kreta\Component\Issue\Model\Interfaces\IssueInterface')->shouldReturn(false);
    }

    function it_does_not_vote_because_it_does_not_support_class(TokenInterface $token, IssueInterface $issue)
    {
        $this->vote($token, $issue, [])->shouldReturn(0);
    }

    function it_does_not_vote_because_it_only_one_attribute_allowed(TokenInterface $token, Project $project)
    {
        $this->shouldThrow(new \InvalidArgumentException('Only one attribute allowed.'))
            ->during('vote', [$token, $project, []]);
    }

    function it_does_not_vote_because_it_does_not_support_attribute(TokenInterface $token, Project $project)
    {
        $this->vote($token, $project, ['non-exist-attribute'])->shouldReturn(0);
    }

    function it_does_not_vote_because_the_current_user_is_not_user_interface_instance(
        TokenInterface $token,
        Project $project
    )
    {
        $token->getUser()->shouldBeCalled()->willReturn(null);

        $this->vote($token, $project, ['add_participant'])->shouldReturn(-1);
    }

    function it_does_not_vote_add_participant_delete_delete_participant_or_edit_grant(
        TokenInterface $token,
        Project $project,
        UserInterface $user
    )
    {
        $token->getUser()->shouldBeCalled()->willReturn($user);
        $project->getUserRole($user)->shouldBeCalled()->willReturn('ROLE_PARTICIPANT');

        $this->vote($token, $project, ['add_participant'])->shouldReturn(-1);
    }

    function it_does_not_vote_view_grant(TokenInterface $token, Project $project, UserInterface $user)
    {
        $token->getUser()->shouldBeCalled()->willReturn($user);
        $project->getUserRole($user)->shouldBeCalled()->willReturn(null);

        $this->vote($token, $project, ['view'])->shouldReturn(-1);
    }

    function it_votes_add_participant_delete_delete_participant_or_edit_because_its_role_project_is_admin(
        TokenInterface $token,
        UserInterface $user,
        Project $project
    )
    {
        $token->getUser()->shouldBeCalled()->willReturn($user);
        $project->getUserRole($user)->shouldBeCalled()->willReturn('ROLE_ADMIN');

        $this->vote($token, $project, ['add_participant'])->shouldReturn(1);
    }

    function it_votes(TokenInterface $token, UserInterface $user, ProjectInterface $project)
    {
        $token->getUser()->shouldBeCalled()->willReturn($user);
        $project->getUserRole($user)->shouldBeCalled()->willReturn('ROLE_PARTICIPANT');

        $this->vote($token, $project, ['view'])->shouldReturn(1);
    }
}
