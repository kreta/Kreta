<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\Component\Project\Factory;

use Kreta\Component\Project\Model\Interfaces\ProjectInterface;
use PhpSpec\ObjectBehavior;

/**
 * Class IssueTypeFactorySpec.
 *
 * @package spec\Kreta\Component\Project\Factory
 */
class IssueTypeFactorySpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('Kreta\Component\Project\Model\IssueType');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Component\Project\Factory\IssueTypeFactory');
    }

    function it_creates_a_issue_type(ProjectInterface $project)
    {
        $this->create($project, 'Issue type name')->shouldReturnAnInstanceOf('Kreta\Component\Project\Model\IssueType');
    }
}
