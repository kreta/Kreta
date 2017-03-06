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

use Kreta\SharedKernel\Domain\Model\Exception;
use Kreta\TaskManager\Domain\Model\Project\Task\TaskDoesNotExistException;
use PhpSpec\ObjectBehavior;

class TaskDoesNotExistExceptionSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(TaskDoesNotExistException::class);
        $this->shouldHaveType(Exception::class);
    }

    function it_returns_a_message()
    {
        $this->getMessage()->shouldReturn('The task does not exist');
    }
}
