<?php

/*
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
 * Class PriorityFactorySpec.
 *
 * @package spec\Kreta\Component\Project\Factory
 */
class PriorityFactorySpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('Kreta\Component\Project\Model\Priority');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Component\Project\Factory\PriorityFactory');
    }

    function it_creates_a_issue_type(ProjectInterface $project)
    {
        $this->create($project, 'Priority name')->shouldReturnAnInstanceOf('Kreta\Component\Project\Model\Priority');
    }
}
