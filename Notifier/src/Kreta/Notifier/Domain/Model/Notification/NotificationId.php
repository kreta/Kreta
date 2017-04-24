<?php

declare(strict_types=1);

namespace Kreta\Notifier\Domain\Model\Notification;

use Kreta\SharedKernel\Domain\Model\Identity\Id;

class NotificationId extends Id
{
    public static function generate(?string $id = null) : NotificationId
    {
        return new static($id);
    }
}
