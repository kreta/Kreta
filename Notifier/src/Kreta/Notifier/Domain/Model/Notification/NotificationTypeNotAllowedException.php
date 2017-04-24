<?php

declare(strict_types=1);

namespace Kreta\Notifier\Domain\Model\Notification;

use Kreta\SharedKernel\Domain\Model\Exception;

class NotificationTypeNotAllowedException extends Exception
{
    public function __construct(string $type)
    {
        parent::__construct(sprintf('Notification type "%s" not allowed', $type));
    }
}
