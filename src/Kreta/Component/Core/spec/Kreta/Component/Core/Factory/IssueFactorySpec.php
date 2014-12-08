<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\Component\Core\Factory;

use Kreta\Component\Core\Model\Interfaces\ProjectInterface;
use Kreta\Component\Core\Model\Interfaces\StatusInterface;
use Kreta\Component\Core\Model\Interfaces\UserInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Class IssueFactorySpec.
 *
 * @package spec\Kreta\Component\Core\Factory
 */
class IssueFactorySpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('Kreta\Component\Core\Model\Issue');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Component\Core\Factory\IssueFactory');
    }

    function it_creates_a_issue(
        ProjectInterface $project,
        StatusInterface $status,
        UserInterface $user
    )
    {
        $project->getStatuses()->shouldBeCalled()->willReturn([$status]);
        $status->getType()->shouldBeCalled()->willReturn('initial');

        $this->create($project, $user)->shouldReturnAnInstanceOf('Kreta\Component\Core\Model\Issue');
    }
}
