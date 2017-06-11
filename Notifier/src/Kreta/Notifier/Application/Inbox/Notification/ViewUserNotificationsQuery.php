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

namespace Kreta\Notifier\Application\Inbox\Notification;

class ViewUserNotificationsQuery
{
    private $userId;
    private $offset;
    private $limit;
    private $status;

    public function __construct(string $userId, int $offset, int $limit, string $status = null)
    {
        $this->limit = $limit;
        $this->offset = $offset;
        $this->status = $status;
        $this->userId = $userId;
    }

    public function userId() : string
    {
        return $this->userId;
    }

    public function offset() : int
    {
        return $this->offset;
    }

    public function limit() : int
    {
        return $this->limit;
    }

    public function status() : ?string
    {
        return $this->status;
    }
}
