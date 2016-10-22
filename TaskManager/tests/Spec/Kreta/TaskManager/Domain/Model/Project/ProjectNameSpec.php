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

namespace Spec\Kreta\TaskManager\Domain\Model\Project;

use Kreta\TaskManager\Domain\Model\Project\ProjectName;
use Kreta\TaskManager\Domain\Model\Project\ProjectNameEmptyException;
use PhpSpec\ObjectBehavior;

class ProjectNameSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('Project name');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(ProjectName::class);
    }

    function it_does_not_allow_empty_names()
    {
        $this->beConstructedWith('');
        $this->shouldThrow(ProjectNameEmptyException::class)->duringInstantiation();
    }

    function it_returns_name()
    {
        $this->name()->shouldReturn('Project name');
        $this->__toString()->shouldReturn('Project name');
    }
}
