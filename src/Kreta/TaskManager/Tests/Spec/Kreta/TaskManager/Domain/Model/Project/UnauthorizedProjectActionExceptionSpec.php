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

use Kreta\SharedKernel\Domain\Model\Exception;
use Kreta\TaskManager\Domain\Model\Project\UnauthorizedProjectActionException;
use PhpSpec\ObjectBehavior;

class UnauthorizedProjectActionExceptionSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(UnauthorizedProjectActionException::class);
        $this->shouldHaveType(Exception::class);
    }

    function it_returns_a_message()
    {
        $this->getMessage()->shouldReturn('Not allowed to perform this project action');
    }
}
