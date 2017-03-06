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

namespace Spec\Kreta\TaskManager\Domain\Model\Project\Task;

use Kreta\TaskManager\Domain\Model\Project\Task\TaskTitle;
use Kreta\TaskManager\Domain\Model\Project\Task\TaskTitleCannotBeEmptyException;
use PhpSpec\ObjectBehavior;

class TaskTitleSpec extends ObjectBehavior
{
    function it_creates_a_task_title()
    {
        $this->beConstructedWith('Sample title');

        $this->shouldHaveType(TaskTitle::class);

        $this->title()->shouldReturn('Sample title');
        $this->__toString()->shouldReturn('Sample title');
    }

    function it_cannot_be_created_if_title_is_empty()
    {
        $this->beConstructedWith('');
        $this->shouldThrow(TaskTitleCannotBeEmptyException::class)->duringInstantiation();
    }
}
