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

namespace spec\Kreta\Bundle\WorkflowBundle\Security\Authorization\Voter;

use Kreta\Component\Issue\Model\Interfaces\IssueInterface;
use Kreta\Component\Project\Model\Interfaces\ProjectInterface;
use Kreta\Component\Project\Model\Project;
use Kreta\Component\User\Model\Interfaces\UserInterface;
use Kreta\Component\Workflow\Model\Workflow;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

/**
 * Class WorkflowVoterSpec.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
 */
class WorkflowVoterSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Bundle\WorkflowBundle\Security\Authorization\Voter\WorkflowVoter');
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
        $this->supportsAttribute('view')->shouldReturn(true);
    }

    function it_does_not_support_attribute()
    {
        $this->supportsAttribute('non-exist-attribute')->shouldReturn(false);
    }

    function it_supports_class()
    {
        $this->supportsClass('Kreta\Component\Workflow\Model\Interfaces\WorkflowInterface')->shouldReturn(true);
    }

    function it_does_not_support_class()
    {
        $this->supportsClass('Kreta\Component\Issue\Model\Interfaces\IssueInterface')->shouldReturn(false);
    }

    function it_does_not_vote_because_it_does_not_support_class(TokenInterface $token, IssueInterface $issue)
    {
        $this->vote($token, $issue, [])->shouldReturn(0);
    }

    function it_does_not_vote_because_it_only_one_attribute_allowed(TokenInterface $token, Workflow $workflow)
    {
        $this->shouldThrow(new \InvalidArgumentException('Only one attribute allowed.'))
            ->during('vote', [$token, $workflow, []]);
    }

    function it_does_not_vote_because_it_does_not_support_attribute(TokenInterface $token, Workflow $workflow)
    {
        $this->vote($token, $workflow, ['non-exist-attribute'])->shouldReturn(0);
    }

    function it_does_not_vote_because_the_current_user_is_not_user_interface_instance(
        TokenInterface $token,
        Workflow $workflow
    )
    {
        $token->getUser()->shouldBeCalled()->willReturn(null);

        $this->vote($token, $workflow, ['view'])->shouldReturn(-1);
    }

    function it_does_not_vote_edit_or_manage_status_grant(
        TokenInterface $token,
        Workflow $workflow,
        UserInterface $user,
        UserInterface $user2
    )
    {
        $token->getUser()->shouldBeCalled()->willReturn($user);
        $user->getId()->shouldBeCalled()->willReturn('user-id');
        $workflow->getCreator()->shouldBeCalled()->willReturn($user2);
        $user2->getId()->shouldBeCalled()->willReturn('user-2-id');

        $this->vote($token, $workflow, ['edit'])->shouldReturn(-1);
        $this->vote($token, $workflow, ['manage_status'])->shouldReturn(-1);
    }

    function it_does_not_vote_view_grant(
        TokenInterface $token,
        Project $project,
        UserInterface $user,
        Workflow $workflow
    )
    {
        $token->getUser()->shouldBeCalled()->willReturn($user);
        $workflow->getProjects()->shouldBeCalled()->willReturn([$project]);
        $project->getUserRole($user)->shouldBeCalled()->willReturn(null);

        $this->vote($token, $workflow, ['view'])->shouldReturn(-1);
    }

    function it_does_not_vote_manage_status_or_edit_because_the_current_user_is_not_the_creator_of_the_workflow(
        TokenInterface $token,
        Workflow $workflow,
        UserInterface $user,
        UserInterface $user2
    )
    {
        $token->getUser()->shouldBeCalled()->willReturn($user);
        $user->getId()->shouldBeCalled()->willReturn('user-id');
        $workflow->getCreator()->shouldBeCalled()->willReturn($user2);
        $user2->getId()->shouldBeCalled()->willReturn('user-2-id');

        $this->vote($token, $workflow, ['edit'])->shouldReturn(-1);
        $this->vote($token, $workflow, ['manage_status'])->shouldReturn(-1);
    }

    function it_votes_manage_status_or_edit_because_the_current_user_is_the_creator_of_the_workflow(
        TokenInterface $token,
        Workflow $workflow,
        UserInterface $user
    )
    {
        $token->getUser()->shouldBeCalled()->willReturn($user);
        $user->getId()->shouldBeCalled()->willReturn('user-id');
        $workflow->getCreator()->shouldBeCalled()->willReturn($user);
        $user->getId()->shouldBeCalled()->willReturn('user-id');

        $this->vote($token, $workflow, ['edit'])->shouldReturn(1);
        $this->vote($token, $workflow, ['manage_status'])->shouldReturn(1);
    }

    function it_votes(
        TokenInterface $token,
        UserInterface $user,
        ProjectInterface $project,
        Workflow $workflow
    )
    {
        $token->getUser()->shouldBeCalled()->willReturn($user);
        $workflow->getProjects()->shouldBeCalled()->willReturn([$project]);
        $project->getUserRole($user)->shouldBeCalled()->willReturn('ROLE_PARTICIPANT');

        $this->vote($token, $workflow, ['view'])->shouldReturn(1);
    }
}
