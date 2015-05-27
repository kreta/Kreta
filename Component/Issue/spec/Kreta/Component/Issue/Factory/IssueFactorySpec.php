<?php

/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\Component\Issue\Factory;

use Kreta\Component\Issue\Model\Interfaces\IssueInterface;
use Kreta\Component\Project\Model\Interfaces\IssueTypeInterface;
use Kreta\Component\Project\Model\Interfaces\IssuePriorityInterface;
use Kreta\Component\Project\Model\Interfaces\ProjectInterface;
use Kreta\Component\Workflow\Model\Interfaces\StatusInterface;
use Kreta\Component\User\Model\Interfaces\UserInterface;
use Kreta\Component\Workflow\Model\Interfaces\WorkflowInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Class IssueFactorySpec.
 *
 * @package spec\Kreta\Component\Issue\Factory
 */
class IssueFactorySpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('Kreta\Component\Issue\Model\Issue');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Component\Issue\Factory\IssueFactory');
    }

    function it_creates_a_issue(
        ProjectInterface $project,
        WorkflowInterface $workflow,
        StatusInterface $status,
        UserInterface $user,
        IssueTypeInterface $type,
        IssuePriorityInterface $issuePriority,
        IssueInterface $parent
    )
    {
        $project->getWorkflow()->shouldBeCalled()->willReturn($workflow);
        $workflow->getStatuses()->shouldBeCalled()->willReturn([$status]);
        $status->getType()->shouldBeCalled()->willReturn('initial');

        $this->create($user, $type, $issuePriority, $project, $parent)
            ->shouldReturnAnInstanceOf('Kreta\Component\Issue\Model\Issue');
    }
}
