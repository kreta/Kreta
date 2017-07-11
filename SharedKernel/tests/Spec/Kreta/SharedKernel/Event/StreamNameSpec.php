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

namespace Spec\Kreta\SharedKernel\Event;

use Kreta\SharedKernel\Domain\Model\Identity\Id;
use Kreta\SharedKernel\Event\StreamName;
use PhpSpec\ObjectBehavior;

class StreamNameSpec extends ObjectBehavior
{
    function it_can_be_created(Id $aggregateId)
    {
        $this->beConstructedWith($aggregateId, 'StreamName');
        $this->shouldHaveType(StreamName::class);
        $this->aggregateId()->shouldReturn($aggregateId);

        $aggregateId->id()->willReturn('123456789');
        $this->name()->shouldReturn('StreamName-123456789');
        $this->__toString()->shouldReturn('StreamName-123456789');
    }
}
