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

class Notification
{
    private $id;
    private $body;
    private $publishedOn;
    private $readOn;
    private $status;

    private function __construct(NotificationId $id, NotificationBody $body)
    {
        $this->id = $id;
        $this->body = $body;
        $this->publishedOn = new \DateTimeImmutable();
        $this->status = NotificationStatus::unread();
    }

    public static function broadcast(NotificationId $id, NotificationBody $body) : self
    {
        return new self($id, $body);
    }

    public function read() : void
    {
        $this->status = NotificationStatus::read();
        $this->readOn = new \DateTimeImmutable();
    }

    public function unread() : void
    {
        $this->status = NotificationStatus::unread();
        $this->readOn = null;
    }

    public function id() : NotificationId
    {
        return $this->id;
    }

    public function body() : NotificationBody
    {
        return $this->body;
    }

    public function publishedOn() : \DateTimeInterface
    {
        return $this->publishedOn;
    }

    public function readOn() : ?\DateTimeInterface
    {
        return $this->readOn;
    }

    public function status() : NotificationStatus
    {
        return $this->status;
    }

    public function __toString() : string
    {
        return (string) $this->id()->id();
    }
}
