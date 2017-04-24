<?php

declare(strict_types=1);

namespace Kreta\Notifier\Domain\Model\Notification;

use Kreta\SharedKernel\Domain\Model\Identity\Id;

class NotificationOwnerId extends Id
{
    public static function generate(?string $id = null) : NotificationOwnerId
    {
        return new static($id);
    }
}
