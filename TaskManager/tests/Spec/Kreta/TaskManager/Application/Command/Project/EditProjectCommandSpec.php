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

namespace Spec\Kreta\TaskManager\Application\Command\Project;

use Kreta\TaskManager\Application\Command\Project\EditProjectCommand;
use PhpSpec\ObjectBehavior;

class EditProjectCommandSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('project-id', 'Project name', 'editor-id', 'project-name');
    }

    function it_can_be_created()
    {
        $this->shouldHaveType(EditProjectCommand::class);

        $this->id()->shouldReturn('project-id');
        $this->name()->shouldReturn('Project name');
        $this->editorId()->shouldReturn('editor-id');
        $this->slug()->shouldReturn('project-name');
    }

    function it_can_be_created_without_a_slug()
    {
        $this->beConstructedWith('project-id', 'Project name', 'editor-id');

        $this->id()->shouldReturn('project-id');
        $this->name()->shouldReturn('Project name');
        $this->editorId()->shouldReturn('editor-id');
        $this->slug()->shouldReturn(null);
    }
}
