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
use Kreta\Component\Core\Model\Interfaces\UserInterface;
use PhpSpec\ObjectBehavior;

/**
 * Class ParticipantFactorySpec.
 *
 * @package spec\Kreta\Component\Core\Factory
 */
class ParticipantFactorySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Component\Core\Factory\ParticipantFactory');
    }

    function it_creates_a_project_role(ProjectInterface $project, UserInterface $user)
    {
        $this->create($project, $user)->shouldReturnAnInstanceOf('Kreta\Component\Core\Model\Participant');
    }
}
