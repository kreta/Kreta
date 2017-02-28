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

namespace Spec\Kreta\SharedKernel\Domain\Model;

use Kreta\SharedKernel\Domain\Model\AggregateDoesNotExistException;
use Kreta\SharedKernel\Domain\Model\Exception;
use Kreta\SharedKernel\Domain\Model\Identity\Id;
use PhpSpec\ObjectBehavior;

class AggregateDoesNotExistExceptionSpec extends ObjectBehavior
{
    function let(Id $aggregateId)
    {
        $aggregateId->__toString()->willReturn('id');
        $this->beConstructedWith($aggregateId);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(AggregateDoesNotExistException::class);
    }

    function it_extends_exception()
    {
        $this->shouldHaveType(Exception::class);
    }
}
