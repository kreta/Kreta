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

namespace Kreta\Notifier\Domain\ReadModel\Inbox\Notification;

class Notification implements \JsonSerializable
{
    public $id;
    public $userId;
    public $type;
    public $body;
    public $publishedOn;
    public $readOn;
    public $status;

    public function __construct(
        string $id,
        string $userId,
        string $type,
        string $body,
        int $publishedOn,
        string $status,
        int $readOn = null
    ) {
        $this->id = $id;
        $this->userId = $userId;
        $this->type = $type;
        $this->body = $body;
        $this->publishedOn = $publishedOn;
        $this->status = $status;
        $this->readOn = $readOn;
    }

    public static function fromArray(array $notificationData) : self
    {
        return new self(
            $notificationData['id'],
            $notificationData['user_id'],
            $notificationData['type'],
            $notificationData['body'],
            $notificationData['published_on'],
            $notificationData['status'],
            $notificationData['read_on']
        );
    }

    public function jsonSerialize() : array
    {
        return [
            'id'           => $this->id,
            'user_id'      => $this->userId,
            'type'         => $this->type,
            'body'         => $this->body,
            'published_on' => $this->publishedOn,
            'status'       => $this->status,
            'read_on'      => $this->readOn,
        ];
    }
}
