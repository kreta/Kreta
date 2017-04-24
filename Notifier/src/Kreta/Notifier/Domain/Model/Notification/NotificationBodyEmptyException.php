<?php

declare(strict_types=1);

namespace Kreta\Notifier\Domain\Model\Notification;

use Kreta\SharedKernel\Domain\Model\Exception;

class NotificationBodyEmptyException extends Exception
{
    public function __construct()
    {
        parent::__construct('Notification body must not be empty');
    }
}
