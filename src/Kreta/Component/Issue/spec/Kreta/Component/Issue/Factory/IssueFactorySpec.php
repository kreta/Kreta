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

namespace spec\Kreta\Component\Issue\Factory;

use Kreta\Component\Issue\Model\Interfaces\IssueInterface;
use Kreta\Component\Project\Model\Interfaces\IssuePriorityInterface;
use Kreta\Component\Project\Model\Interfaces\ProjectInterface;
use Kreta\Component\User\Model\Interfaces\UserInterface;
use Kreta\Component\Workflow\Model\Interfaces\StatusInterface;
use Kreta\Component\Workflow\Model\Interfaces\WorkflowInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Class IssueFactorySpec.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
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
        IssuePriorityInterface $issuePriority,
        IssueInterface $parent
    )
    {
        $project->getWorkflow()->shouldBeCalled()->willReturn($workflow);
        $workflow->getStatuses()->shouldBeCalled()->willReturn([$status]);
        $status->getType()->shouldBeCalled()->willReturn('initial');

        $this->create($user, $issuePriority, $project, $parent)
            ->shouldReturnAnInstanceOf('Kreta\Component\Issue\Model\Issue');
    }
}
