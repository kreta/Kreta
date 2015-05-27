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

use Kreta\Component\Project\Model\Interfaces\ProjectInterface;
use PhpSpec\ObjectBehavior;

/**
 * Class IssuePrioritySpec.
 *
 * @package spec\Kreta\Component\Project\Model
 */
class IssuePrioritySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Component\Project\Model\IssuePriority');
    }

    function it_implements_issue_priority_interface()
    {
        $this->shouldImplement('Kreta\Component\Project\Model\Interfaces\IssuePriorityInterface');
    }

    function it_does_not_have_id_by_default()
    {
        $this->getId()->shouldReturn(null);
        $this->__toString()->shouldReturn(null);
    }

    function its_name_is_mutable()
    {
        $this->setName('The dummy priority')->shouldReturn($this);
        $this->getName()->shouldReturn('The dummy priority');
    }

    function its_project_is_mutable(ProjectInterface $project)
    {
        $this->setProject($project)->shouldReturn($this);
        $this->getProject()->shouldReturn($project);
    }
}
