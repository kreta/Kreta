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

namespace Kreta\Notifier\Infrastructure\Projection\ReadModel\Inbox;

use Kreta\Notifier\Domain\Model\Inbox\NotificationStatus;

class Notification
{
    public $id;
    public $body;
    public $publishedOn;
    public $readOn;
    public $status;

    public function __construct(string $id, string $body, \DateTimeInterface $publishedOn)
    {
        $this->id = $id;
        $this->body = $body;
        $this->publishedOn = $publishedOn;
        $this->status = (NotificationStatus::unread())->status();
    }
}
