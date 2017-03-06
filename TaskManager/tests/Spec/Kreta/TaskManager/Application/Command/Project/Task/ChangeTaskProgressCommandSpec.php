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

use Kreta\TaskManager\Application\Command\Project\Task\ChangeTaskProgressCommand;
use PhpSpec\ObjectBehavior;

class ChangeTaskProgressCommandSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('task-id', 'doing', 'editor-id');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(ChangeTaskProgressCommand::class);

        $this->id()->shouldReturn('task-id');
        $this->progress()->shouldReturn('doing');
        $this->editorId()->shouldReturn('editor-id');
    }
}
