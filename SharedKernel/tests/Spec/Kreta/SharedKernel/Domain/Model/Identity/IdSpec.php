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

namespace Spec\Kreta\SharedKernel\Domain\Model\Identity;

use Kreta\SharedKernel\Domain\Model\Identity\BaseId;
use Kreta\SharedKernel\Domain\Model\Identity\Id;
use Kreta\SharedKernel\Tests\Double\Domain\Model\Identity\IdStub;
use PhpSpec\ObjectBehavior;

class IdSpec extends ObjectBehavior
{
    function let()
    {
        $this->beAnInstanceOf(IdStub::class);
        $this->beConstructedGenerate('1');
    }

    function it_extends_id()
    {
        $this->shouldHaveType(Id::class);
    }

    function it_implements_base_id()
    {
        $this->shouldImplement(BaseId::class);
    }

    function it_generates_an_id()
    {
        $this::generate()->shouldReturnAnInstanceOf(IdStub::class);
        $this->id()->shouldReturn('1');
        $this->__toString()->shouldReturn('1');
    }

    function it_compares_two_ids(IdStub $id, IdStub $id2)
    {
        $id->id()->shouldBeCalled()->willReturn('1');
        $id2->id()->shouldBeCalled()->willReturn('2');

        $this->equals($id2)->shouldReturn(false);
        $this->equals($id)->shouldReturn(true);
    }
}
