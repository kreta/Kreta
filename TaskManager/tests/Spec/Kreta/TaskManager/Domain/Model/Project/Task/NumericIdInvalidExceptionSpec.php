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

use Kreta\SharedKernel\Domain\Model\InvalidArgumentException;
use Kreta\TaskManager\Domain\Model\Project\Task\NumericIdInvalidException;
use PhpSpec\ObjectBehavior;

class NumericIdInvalidExceptionSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(NumericIdInvalidException::class);
        $this->shouldHaveType(InvalidArgumentException::class);
    }

    function it_should_return_message()
    {
        $this->getMessage()->shouldReturn('The given numeric id is not a valid');
    }
}
