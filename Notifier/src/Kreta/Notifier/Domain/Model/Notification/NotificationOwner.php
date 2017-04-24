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

namespace Kreta\Notifier\Domain\Model\Notification;

use Kreta\Notifier\Domain\Model\User\UserId;

class NotificationOwner
{
    private $id;
    private $userId;

    public function __construct(NotificationOwnerId $id, UserId $userId)
    {
        $this->id = $id;
        $this->userId = $userId;
    }

    public function id() : NotificationOwnerId
    {
        return $this->id;
    }

    public function userId() : UserId
    {
        return $this->userId;
    }

    public function __toString() : string
    {
        return (string) $this->id->id();
    }
}
