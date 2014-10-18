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

use Kreta\Component\Core\Model\Interfaces\IssueInterface;
use Kreta\Component\Core\Model\Interfaces\ProjectRoleInterface;
use Kreta\Component\Core\Model\Interfaces\UserInterface;
use Kreta\Component\Core\Model\Project;
use Kreta\Component\Core\Model\ProjectRole;
use Kreta\Component\Core\Model\User;
use PhpSpec\ObjectBehavior;

/**
 * Class ProjectSpec.
 *
 * @package spec\Kreta\Component\Core\Model
 */
class ProjectSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Component\Core\Model\Project');
    }

    function it_extends_abstract_model()
    {
        $this->shouldHaveType('Kreta\Component\Core\Model\Abstracts\AbstractModel');
    }

    function it_implements_project_interface()
    {
        $this->shouldImplement('Kreta\Component\Core\Model\Interfaces\ProjectInterface');
    }

    function its_issues_participants_and_project_roles_are_collection()
    {
        $this->getIssues()->shouldHaveType('Doctrine\Common\Collections\ArrayCollection');
        $this->getProjectRoles()->shouldHaveType('Doctrine\Common\Collections\ArrayCollection');
    }

    function its_issues_are_mutable(IssueInterface $issue)
    {
        $this->getIssues()->shouldHaveCount(0);

        $this->addIssue($issue);

        $this->getIssues()->shouldHaveCount(1);

        $this->removeIssue($issue);

        $this->getIssues()->shouldHaveCount(0);
    }

    function its_name_is_mutable()
    {
        $this->setName('Dummy name that it is a test for the PHPSpec')->shouldReturn($this);
        $this->getName()->shouldReturn('Dummy name that it is a test for the PHPSpec');

        $this->getShortName()->shouldReturn('Dummy name that it is a te...');
    }

    function its_project_roles_are_be_mutable(ProjectRoleInterface $projectRole)
    {
        $this->getProjectRoles()->shouldHaveCount(0);

        $this->addProjectRole($projectRole);

        $this->getProjectRoles()->shouldHaveCount(1);

        $this->removeProjectRole($projectRole);

        $this->getProjectRoles()->shouldHaveCount(0);
    }

    function its_short_name_is_mutable()
    {
        $this->setShortName('Dummy short name that it is a test for the PHPSpec')->shouldReturn($this);
        $this->getShortName()->shouldReturn('Dummy short name that it i...');

        $this->setShortName('Dummy short name')->shouldReturn($this);
        $this->getShortName()->shouldReturn('Dummy short name');
    }

    function it_does_not_get_user_role(UserInterface $anotherUser)
    {
        $project = new Project();
        $user = new User();
        $projectRole = new ProjectRole($project, $user);

        $this->addProjectRole($projectRole)->shouldReturn($this);
        $anotherUser->getId()->shouldBeCalled()->willReturn('user-id');

        $this->getUserRole($anotherUser)->shouldReturn(null);
    }

    function it_gets_user_role(UserInterface $anotherUser)
    {
        $project = new Project();
        $user = new User();
        $projectRole = new ProjectRole($project, $user);
        $projectRole->setRole('ROLE_ADMIN');

        $this->addProjectRole($projectRole)->shouldReturn($this);

        $this->getUserRole($anotherUser)->shouldReturn('ROLE_ADMIN');
    }
}
