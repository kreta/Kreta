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

use Kreta\TaskManager\Domain\Model\Project\Task\NumericId;
use Kreta\TaskManager\Domain\Model\Project\Task\NumericIdInvalidException;
use PhpSpec\ObjectBehavior;

class NumericIdSpec extends ObjectBehavior
{
    function it_constructs()
    {
        $this->beConstructedWith(2);
        $this->shouldHaveType(NumericId::class);
        $this->id()->shouldReturn(2);
        $this->__toString()->shouldReturn('2');
    }

    function it_constructs_from_previous_id()
    {
        $this->beConstructedFromPrevious(0);
        $this->shouldHaveType(NumericId::class);
        $this->id()->shouldReturn(1);
        $this->__toString()->shouldReturn('1');

        $this::fromPrevious(1)->shouldReturnAnInstanceOf(NumericId::class);
    }

    function it_cannot_construct_with_invalid_id()
    {
        $this->beConstructedWith(0);

        $this->shouldThrow(NumericIdInvalidException::class)->duringInstantiation();
    }
}
