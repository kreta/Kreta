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

namespace Spec\Kreta\Notifier\Domain\Model\Inbox;

use Kreta\Notifier\Domain\Model\Inbox\User;
use Kreta\Notifier\Domain\Model\Inbox\UserId;
use Kreta\Notifier\Domain\Model\Inbox\UserSignedUp;
use Kreta\SharedKernel\Domain\Model\AggregateRoot;
use Kreta\SharedKernel\Domain\Model\DomainEventCollection;
use Kreta\SharedKernel\Domain\Model\EventSourcedAggregateRoot;
use Kreta\SharedKernel\Event\EventStream;
use PhpSpec\ObjectBehavior;

class UserSpec extends ObjectBehavior
{
    function let(UserId $id)
    {
        $id->id()->willReturn('user-id');
        $this->beConstructedSignUp($id);
    }

    function it_can_be_signed_up()
    {
        $this->shouldHaveType(User::class);
        $this->shouldHaveType(AggregateRoot::class);
        $this->shouldImplement(EventSourcedAggregateRoot::class);
        $this->shouldHavePublished(UserSignedUp::class);
        $this->id()->shouldReturnAnInstanceOf(UserId::class);
        $this->__toString()->shouldReturn('user-id');
    }

    function it_can_be_reconstituted_user(
        EventStream $stream,
        UserId $id,
        UserSignedUp $userSignedUp,
        DomainEventCollection $collection
    ) {
        $collection->toArray()->willReturn([
            $userSignedUp,
        ]);
        $stream->events()->willReturn($collection);
        $stream->aggregateRootId()->shouldBeCalled()->willReturn($id);
        $this->beConstructedReconstitute($stream);
        $this->id()->shouldReturn($id);
        $id->id()->shouldBeCalled()->willReturn('user-id');
        $this->__toString()->shouldReturn('user-id');
    }
}
