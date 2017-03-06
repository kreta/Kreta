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

declare(strict_types=1);

namespace Spec\Kreta\TaskManager\Application\Command\Project\Task;

use Kreta\TaskManager\Application\Command\Project\Task\EditTaskCommand;
use PhpSpec\ObjectBehavior;

class EditTaskCommandSpec extends ObjectBehavior
{
    function it_can_be_edited_with_basic_info()
    {
        $this->beConstructedWith(
            'task-id',
            'title',
            'description',
            'editor-id'
        );
        $this->shouldHaveType(EditTaskCommand::class);
        $this->id()->shouldReturn('task-id');
        $this->title()->shouldReturn('title');
        $this->description()->shouldReturn('description');
        $this->editorId()->shouldReturn('editor-id');
    }
}
