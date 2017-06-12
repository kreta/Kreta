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

namespace Kreta\Notifier\Domain\Model\Inbox;

use Kreta\SharedKernel\Domain\Model\AggregateRoot;
use Kreta\SharedKernel\Domain\Model\EventSourcedAggregateRoot;
use Kreta\SharedKernel\Event\Stream;

class User extends AggregateRoot implements EventSourcedAggregateRoot
{
    private $id;

    private function __construct(UserId $id)
    {
        $this->id = $id;
    }

    public static function signUp(UserId $id) : self
    {
        $user = new self($id);
        $user->publish(new UserSignedUp($id));

        return $user;
    }

    protected function applyUserSignedUp(UserSignedUp $event) : void
    {
    }

    public static function reconstitute(Stream $stream) : self
    {
        $user = new self($stream->name()->aggregateId());
        $events = $stream->events()->toArray();
        foreach ($events as $event) {
            $user->apply($event);
        }

        return $user;
    }

    public function id() : UserId
    {
        return $this->id;
    }

    public function __toString() : string
    {
        return (string) $this->id()->id();
    }
}
