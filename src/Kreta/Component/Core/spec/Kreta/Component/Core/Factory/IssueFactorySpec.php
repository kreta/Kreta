<?php

/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

namespace spec\Kreta\CoreBundle\Factory;

use PhpSpec\ObjectBehavior;

/**
 * Class IssueFactorySpec.
 *
 * @package spec\Kreta\CoreBundle\Factory
 */
class IssueFactorySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Kreta\CoreBundle\Factory\IssueFactory');
    }

    function it_extends_abstract_factory()
    {
        $this->shouldHaveType('Kreta\CoreBundle\Factory\Abstracts\AbstractFactory');
    }

    function it_creates_a_issue()
    {
        $this->create()->shouldReturnAnInstanceOf('Kreta\CoreBundle\Model\Issue');
    }
}
