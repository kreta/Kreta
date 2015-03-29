<?php

/**
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
 * Class IssueTypeSpec.
 *
 * @package spec\Kreta\Component\Project\Model
 */
class IssueTypeSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Component\Project\Model\IssueType');
    }

    function it_implements_issue_type_interface()
    {
        $this->shouldImplement('Kreta\Component\Project\Model\Interfaces\IssueTypeInterface');
    }

    function it_does_not_have_id_by_default()
    {
        $this->getId()->shouldReturn(null);
    }

    function its_name_is_mutable()
    {
        $this->setName('The dummy issue type')->shouldReturn($this);
        $this->getName()->shouldReturn('The dummy issue type');
    }

    function its_project_is_mutable(ProjectInterface $project)
    {
        $this->setProject($project)->shouldReturn($this);
        $this->getProject()->shouldReturn($project);
    }
}
