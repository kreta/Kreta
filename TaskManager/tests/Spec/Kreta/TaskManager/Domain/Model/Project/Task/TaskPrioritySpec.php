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

use Kreta\TaskManager\Domain\Model\Project\Task\TaskPriority;
use Kreta\TaskManager\Domain\Model\Project\Task\TaskPriorityNotAllowedException;
use PhpSpec\ObjectBehavior;

class TaskPrioritySpec extends ObjectBehavior
{
    function it_does_not_create_priority_with_invalid_priority()
    {
        $this->beConstructedWith('invalid-priority');
        $this->shouldThrow(TaskPriorityNotAllowedException::class)->duringInstantiation();
    }

    function it_creates_a_low_priority_task_value()
    {
        $this->beConstructedLow();
        $this->priority()->shouldReturn(TaskPriority::LOW);
        $this->__toString()->shouldReturn(TaskPriority::LOW);
    }

    function it_creates_a_medium_priority_task_value()
    {
        $this->beConstructedMedium();
        $this->priority()->shouldReturn(TaskPriority::MEDIUM);
    }

    function it_creates_a_high_priority_task_value()
    {
        $this->beConstructedHigh();
        $this->priority()->shouldReturn(TaskPriority::HIGH);
    }
}
