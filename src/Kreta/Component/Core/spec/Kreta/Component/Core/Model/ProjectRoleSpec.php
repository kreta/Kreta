<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\Component\Core\Model;

use Kreta\Component\Core\Model\Interfaces\ProjectInterface;
use Kreta\Component\Core\Model\Interfaces\UserInterface;
use PhpSpec\ObjectBehavior;

/**
 * Class ProjectRoleSpec.
 *
 * @package spec\Kreta\Component\Core\Model
 */
class ProjectRoleSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Component\Core\Model\ProjectRole');
    }

    function it_implements_project_role_interface()
    {
        $this->shouldImplement('Kreta\Component\Core\Model\Interfaces\ProjectRoleInterface');
    }

    function its_project_is_mutable(ProjectInterface $project)
    {
        $this->setProject($project)->shouldReturn($this);
        $this->getProject()->shouldReturn($project);
    }

    function its_role_is_mutable()
    {
        $this->setRole('ROLE_DUMMY')->shouldReturn($this);
        $this->getRole()->shouldReturn('ROLE_DUMMY');
    }

    function its_user_is_mutable(UserInterface $user)
    {
        $this->setUser($user)->shouldReturn($this);
        $this->getUser()->shouldReturn($user);
    }
}
