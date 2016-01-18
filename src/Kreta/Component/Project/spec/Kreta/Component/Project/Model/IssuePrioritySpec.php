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

namespace spec\Kreta\Component\Project\Model;

use Kreta\Component\Project\Model\Interfaces\ProjectInterface;
use PhpSpec\ObjectBehavior;

/**
 * Class IssuePrioritySpec.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
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

    function its_color_is_mutable()
    {
        $this->setColor('#969696')->shouldReturn($this);
        $this->getColor()->shouldReturn('#969696');
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
