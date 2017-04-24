<?php

declare(strict_types=1);

namespace Kreta\Notifier\Domain\Model\Notification;

class NotificationBody
{
    private $body;

    public function __construct(string $body)
    {
        if ('' === $body) {
            throw new NotificationBodyEmptyException($body);
        }
        $this->body = $body;
    }

    public function body() : string
    {
        return $this->body;
    }

    public function __toString() : string
    {
        return (string) $this->body;
    }
}
