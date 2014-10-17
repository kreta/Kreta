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

use PhpSpec\ObjectBehavior;

/**
 * Class ProjectRoleSpec.
 *
 * @package spec\Kreta\Component\Core\Factory
 */
class ProjectRoleFactorySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\Component\Core\Factory\ProjectRoleFactory');
    }

    function it_extends_abstract_factory()
    {
        $this->shouldHaveType('Kreta\Component\Core\Factory\Abstracts\AbstractFactory');
    }

    function it_creates_a_project_role()
    {
        $this->create()->shouldReturnAnInstanceOf('Kreta\Component\Core\Model\ProjectRole');
    }
}
